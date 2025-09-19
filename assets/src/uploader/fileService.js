import Api from "./api.js";
import Utils from "./utils.js";

const FileService = {
    retrieveFormData(event) {
        const form = event.currentTarget;
        const formData = new FormData(form);
        const file = formData.get("file");
        const isPublic = formData.get("isPublic");

        return { file, isPublic };
    },

    async initUpload(file) {
        const fingerprint = await Api.getFingerprint(file.name, file.size, file.lastModified);

        const extension = file.name.split('.').pop();
        const mimeType = Utils.mimeType(extension);
        const { uploadSession, resumed } = await Api.initUpload(fingerprint, file.name, file.size, mimeType, extension);

        if (resumed) {
            console.log("Resumed");
        }

        return uploadSession;
    },

    *chunkGenerator(file, chunkSize, receivedChunks = 0) {
        let offset = receivedChunks * chunkSize;
        while (offset < file.size) {
            yield { chunk: file.slice(offset, offset + chunkSize), index: receivedChunks + 1 };
            offset += chunkSize;
        }
    },

    async upload(file, chunkSize, receivedChunks, uploadId, updateProgress){
        const totalChunks = Math.ceil(file.size / chunkSize);

        if (receivedChunks >= totalChunks) {
            updateProgress(Math.floor(100));
            return;
        }

        let generator = this.chunkGenerator(file, chunkSize, receivedChunks);
        let sent = receivedChunks;

        for (const { chunk, index } of generator) {
            let success = false;

            while (!success) {
                try {
                    success = await this.uploadChunk(chunk, uploadId, index);

                    if (success) {
                        sent++;
                        updateProgress(Math.floor((sent / totalChunks) * 100))
                    }
                } catch (e) {
                    success = false;
                    console.error(`Error uploading chunk ${index}:`, e);
                    console.warn(`Retrying chunk ${index}...`);
                    await new Promise(r => setTimeout(r, 1000));
                }
            }
        }
    },

    async uploadChunk(chunk, uploadId, index){
        let success = false;

        for (let attempt = 1; attempt <= 3; attempt++) {
            const response = await Api.uploadChunk(chunk, uploadId);

            if (response.ok) {
                success = true;
                break;
            }
            if (attempt === 3) throw new Error(`Chunk failed ${index}`);

            await new Promise(r => setTimeout(r, attempt * 1000));
        }

        return success;
    },

    async complete(uploadId, isPublic) {
        const visibility = isPublic ? 'public' : 'private';
        const response = await Api.complete(uploadId, visibility);
    }
}

export default FileService;



