<?php

declare(strict_types=1);

namespace App\Media\Service\Handler;

use App\Media\Config\Fingerprint;
use App\Media\Model\DTO\UploadResponse;
use App\Media\Model\Enum\MediaVisibility;
use App\Media\Model\Enum\UploadStatus;
use App\Media\Service\Creator\UploadSessionCreator;
use App\Media\Service\Uploader;
use App\Shared\Context;
use App\Shared\Repository\UploadSessionRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

readonly class UploadHandler
{
    public function __construct(
        private Uploader $uploader,
        private UploadSessionRepository $uploadSessionRepository,
        private UploadSessionCreator $creator,
        private Context $context
    ) {}

    public function handleUpload(Request $request): void
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->files->get('file');
        $visibility = MediaVisibility::from((string) $request->request->get('isPublic'));

        $this->uploader->upload($file, $visibility);

        if (strpos($file->getMimeType(), 'image/') === 0) {
            echo 'processImage';
        }
    }

    public function handleInit(Request $request): UploadResponse
    {
        $payload = $request->getPayload();

        if ($existing = $this->uploadSessionRepository->findActiveByFingerprint($this->context->getUser()->getId(), $payload->get('fingerprint'))) {
            return new UploadResponse($existing, true);
        }

        $uploadSession = $this->creator->create($payload, UploadStatus::ACTIVE);

        return new UploadResponse($uploadSession, false);
    }

    public function handleFingerprint(Request $request): string
    {
        $payload = $request->getPayload();
        $fileLastModified = null;
        if ($modified = $payload->get('fileLastModified')) {
            $fileLastModified = new \DateTime()->setTimestamp($modified);
        }

        return Fingerprint::create($this->context->getUser()->getId(), $payload->getString('filename'), $payload->getInt('filesize'), $fileLastModified);
    }

    public function handleChunk(Request $request): bool
    {
        /**
         * @var UploadedFile $chunk
         */
        $chunk = $request->files->get('chunk');
        $uploadId = (string) $request->request->get('uploadId');

        return $this->uploader->uploadChunk($chunk, $uploadId);
    }

    public function handleAssemble(Request $request): array
    {
        $uploadId = (string) $request->request->get('uploadId');
        $uploadSession = $this->uploadSessionRepository->findById($uploadId);
        $visibility = MediaVisibility::from((string) $request->request->get('isPublic'));

        try {
            $path = $this->uploader->assemble($uploadSession, $visibility);

            return ['success' => true, 'path' => $path];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
