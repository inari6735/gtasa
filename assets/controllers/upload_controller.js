import { Controller } from '@hotwired/stimulus';
import FileService from "../src/uploader/fileService.js";


export default class extends Controller {
    static targets = ['bar', 'label'];

    async submit(event) {
        event.preventDefault();

        const { file, isPublic } = FileService.retrieveFormData(event);
        const { chunkSize, receivedChunks, id } = await FileService.initUpload(file);

        await FileService.upload(file, chunkSize, receivedChunks, id, this.updateProgress.bind(this));
        await FileService.complete(id, isPublic)
    }

    updateProgress(pct) {
        const v = Math.max(0, Math.min(100, pct|0))
        if (this.hasBarTarget) this.barTarget.value = v
        if (this.hasLabelTarget) this.labelTarget.textContent = `${v}%`
    }

    resetProgress() {
        this.updateProgress(0)
    }
}
