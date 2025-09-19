<?php declare(strict_types=1);

namespace App\Media\Service\Creator;

use App\Media\Model\Entity\Chunk;
use App\Media\Model\Enum\UploadStatus;
use App\Media\Model\ValueObject\Extension;
use App\Media\Model\ValueObject\MimeType;
use App\Shared\Context;
use App\Shared\Entity\UploadSession;
use App\Shared\Repository\UploadSessionRepository;
use Symfony\Component\HttpFoundation\InputBag;

readonly class UploadSessionCreator
{
    public function __construct(
        private UploadSessionRepository $repository,
        private UploadSessionBuilder $builder,
        private Context $context
    ) {}

    public function create(InputBag $payload, UploadStatus $status): UploadSession
    {
        $uploadSession = $this->builder->build(
            $this->context->getUser(),
            $payload->get('fingerprint'),
            $payload->get('filename'),
            0,
            Chunk::calculateTotalChunks($payload->get('filesize')),
            Chunk::CHUNK_SIZE,
            $payload->get('filesize'),
            MimeType::create($payload->get('mimeType')),
            Extension::create($payload->get('extension')),
            $status
        );

        $this->repository->save($uploadSession);

        return $uploadSession;
    }
}
