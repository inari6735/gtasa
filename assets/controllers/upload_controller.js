import { Controller } from '@hotwired/stimulus';
import FileService from "../src/uploader/fileService.js";


export default class extends Controller {
    static targets = ['bar', 'label', 'list'];

    files = [];

    onFilesSelected(event) {
        const input = event.target;
        this.files = Array.from(input.files || []);
        this.listTarget.innerHTML = '';
        this.files.forEach(file => this.addItem(file));
    }

    async submit(event) {
        event.preventDefault();

        const { file, isPublic } = FileService.retrieveFormData(event);
        const { chunkSize, receivedChunks, id } = await FileService.initUpload(file);

        await FileService.upload(file, chunkSize, receivedChunks, id, this.updateProgress.bind(this));
        await FileService.complete(id, isPublic)
    }

    addItem(file) {
        const row = document.createElement('div');
        row.className = 'upload-item';
        row.dataset.filename = file.name;

        const name = document.createElement('div');
        name.className = 'name';
        name.textContent = `${file.name} (${this.formatBytes(file.size)})`;

        const status = document.createElement('div');
        status.className = 'status';
        status.textContent = '0%';

        const progress = document.createElement('progress');
        progress.className = 'progress-bar';
        progress.max = 100;
        progress.value = 0;

        row.appendChild(name);
        row.appendChild(status);
        row.appendChild(progress);

        this.listTarget.appendChild(row);

        file.__ui = { row, name, status, progress };
        return row;
    }

    formatBytes(bytes) {
        if (!+bytes) return '0 B';
        const units = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return `${(bytes / Math.pow(1024, i)).toFixed(i ? 1 : 0)} ${units[i]}`;
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
