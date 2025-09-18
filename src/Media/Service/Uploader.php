<?php declare(strict_types=1);

namespace App\Media\Service;

use App\Media\Model\Enum\MediaVisibility;
use App\Media\Service\Creator\MediaCreator;
use App\Shared\Repository\MediaRepository;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Uploader
{
    public function __construct(
        private MediaCreator $mediaCreator,
        private FilesystemOperator $publicStorage,
        private FilesystemOperator $privateStorage,
        private MediaRepository $mediaRepository,
    ) {}

    public function upload(UploadedFile $file, MediaVisibility $visibility): void
    {
        $media = $this->mediaCreator->createMedia($file, $visibility);
        $fs = $this->getFilesystem($visibility);

        try {
            $fs->write($media->getPath(), $file->getContent());
        } catch (\Throwable $e) {
            $this->mediaRepository->delete($media);
        }
    }

    private function getFilesystem(MediaVisibility $visibility): FilesystemOperator
    {
        if ($visibility === MediaVisibility::PUBLIC) {
            return $this->publicStorage;
        }

        return $this->privateStorage;
    }
}
