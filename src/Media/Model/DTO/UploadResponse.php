<?php declare(strict_types=1);

namespace App\Media\Model\DTO;

use App\Shared\Entity\UploadSession;

class UploadResponse
{
    public function __construct(
        public UploadSession $uploadSession,
        public bool $resumed
    ) {}
}
