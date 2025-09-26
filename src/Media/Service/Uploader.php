<?php declare(strict_types=1);

namespace App\Media\Service;

use App\Media\Config\FilenameProcessor;
use App\Media\Config\UploadPath;
use App\Media\Model\Enum\MediaVisibility;
use App\Media\Model\Enum\UploadStatus;
use App\Media\Service\Creator\MediaCreator;
use App\Shared\Entity\UploadSession;
use App\Shared\Repository\MediaRepository;
use App\Shared\Repository\UploadSessionRepository;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Uploader
{
    public function __construct(
        private MediaCreator $mediaCreator,
        private FilesystemOperator $publicStorage,
        private FilesystemOperator $privateStorage,
        private FilesystemOperator $tempStorage,
        private MediaRepository $mediaRepository,
        private UploadSessionRepository $uploadSessionRepository,
        private FilenameProcessor $filenameProcessor,
        private UploadPath $uploadPath
    ) {}

    public function upload(UploadedFile $file, MediaVisibility $visibility): void
    {
        $media = $this->mediaCreator->create($file, $visibility);
        $fs = $this->getFilesystem($visibility);

        try {
            $fs->write($media->getPath(), $file->getContent());
        } catch (\Throwable $e) {
            $this->mediaRepository->delete($media);
        }
    }

    public function uploadChunk(UploadedFile $chunk, string $uploadId): bool
    {
        $uploadSession = $this->uploadSessionRepository->findById($uploadId);

        if (!$uploadSession) {
            return false;
        }

        $index = $uploadSession->getReceivedChunks() + 1;
        $chunkName = $this->createChunkName($index, $uploadSession->getFilename(), $uploadSession->getTotalChunks());
        $chunkPath = UploadPath::chunkPath($uploadId, $chunkName);

        try {
            $this->tempStorage->write($chunkPath, $chunk->getContent());
            $uploadSession->setReceivedChunks($index);
            $this->uploadSessionRepository->save($uploadSession);
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    public function assemble(UploadSession $uploadSession, MediaVisibility $visibility): string
    {
        if ($uploadSession->getStatus() === UploadStatus::COMPLETED->value) {
            throw new \RuntimeException('The upload session has been completed.');
        }

        $chunks = $uploadSession->getReceivedChunks();

        $media = $this->mediaCreator->createFromUploadSession($uploadSession, $visibility);
        $dest = $media->getPath();

        $fs = $this->getFilesystem($visibility);

        try {
            for ($i = 0; $i < $chunks; $i++) {
                $index = $i + 1;
                $chunkName = $this->createChunkName($index, $uploadSession->getFilename(), $uploadSession->getTotalChunks());
                $chunkPath = UploadPath::chunkPath($uploadSession->getId(), $chunkName);

                if (!$this->tempStorage->has($chunkPath)) {
                    throw new \RuntimeException("Missing chunk $i");
                }

                $chunk = $this->tempStorage->readStream($chunkPath);

                $fs->writeStream($dest, $chunk);
            }

            if (!$fs->has($dest)) {
                throw new \RuntimeException("File not created: $dest");
            }

            $this->removeChunks($uploadSession);
            $this->uploadSessionRepository->delete($uploadSession);
        } catch (\Throwable $e) {
            if ($fs->fileExists($dest)) {
                $fs->delete($dest);
            }
            $this->removeChunks($uploadSession);
            $this->mediaRepository->delete($media);
            $this->uploadSessionRepository->delete($uploadSession);

            return 'file not created';
        }

        return $media->getPath();
    }

    private function removeChunks(UploadSession $uploadSession): void
    {
        $chunks = $uploadSession->getReceivedChunks();
        for ($i = 0; $i < $chunks; $i++) {
            $index = $chunks - $i;
            $chunkName = $this->createChunkName($index, $uploadSession->getFilename(), $uploadSession->getTotalChunks());
            $chunkPath = UploadPath::chunkPath($uploadSession->getId(), $chunkName);

            $this->tempStorage->delete($chunkPath);
            $uploadSession->setReceivedChunks($index);
            $this->uploadSessionRepository->save($uploadSession);
        }
    }

    private function getFilesystem(MediaVisibility $visibility): FilesystemOperator
    {
        if ($visibility === MediaVisibility::PUBLIC) {
            return $this->publicStorage;
        }

        return $this->privateStorage;
    }

    private function createChunkName(int $index, string $filename, int $totalChunks): string
    {
        $safeFilename = $this->filenameProcessor->safeFilename($filename);

        return $this->filenameProcessor->chunkName($safeFilename, $index, $totalChunks);
    }
}
