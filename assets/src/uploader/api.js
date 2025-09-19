const Api = {
    async getFingerprint(filename, filesize, fileLastModified) {
        const response = await fetch('/upload/fingerprint', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                filename: filename,
                filesize: filesize,
                fileLastModified: fileLastModified,
            }),
        });

        if (!response.ok) {
            throw new Error(`Fingerprint request failed: ${response.status}`);
        }

        const { fingerprint } = await response.json().then((data) => {
                return data;
        });

        return fingerprint;
    },

    async initUpload(fingerprint, filename, filesize, mimeType, extension) {
        const response = await fetch('/upload/init', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                fingerprint: fingerprint,
                filename: filename,
                filesize: filesize,
                mimeType: mimeType,
                extension: extension
            }),
        });

        if (!response.ok) {
            throw new Error(`Init request failed: ${response.status}`);
        }

        return await response.json().then((data) => {
            return data;
        });
    },

    async uploadChunk(chunk, uploadId) {
        const form = new FormData();
        form.append('chunk', chunk);
        form.append('uploadId', uploadId);

        const response = await fetch('/upload/chunk', {
            method: 'POST',
            body: form
        });

        const { success } = await response.json();

        if (!success) {
            throw new Error(`Chunk request failed: ${response.status}`);
        }

        return response;
    },

    async complete(uploadId, visibility) {
        const form = new FormData();
        form.append('uploadId', uploadId);
        form.append('isPublic', visibility);

        const response = await fetch('/upload/complete', {
            method: 'POST',
            body: form
        });

        return await response.json();
    }
};

export default Api;
