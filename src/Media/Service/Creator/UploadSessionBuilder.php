<?php declare(strict_types=1);

namespace App\Media\Service\Creator;

use App\Media\Model\Enum\UploadStatus;
use App\Media\Model\ValueObject\Extension;
use App\Media\Model\ValueObject\MimeType;
use App\Shared\Entity\UploadSession;
use App\Shared\Entity\User;

class UploadSessionBuilder
{
    public function build(
        User $user,
        string $fingerprint,
        string $filename,
        int $receivedChunks,
        int $totalChunks,
        int $chunkSize,
        int $filesize,
        MimeType $mimeType,
        Extension $extension,
        UploadStatus $uploadStatus
    ): UploadSession
    {
        return new UploadSession()
            ->setUser($user)
            ->setFingerprint($fingerprint)
            ->setFilename($filename)
            ->setReceivedChunks($receivedChunks)
            ->setTotalChunks($totalChunks)
            ->setChunkSize($chunkSize)
            ->setFilesize($filesize)
            ->setMimeType($mimeType->value())
            ->setExtension($extension->value())
            ->setStatus($uploadStatus->value);
    }
}
