<?php declare(strict_types=1);

namespace App\Media\Model\Enum;

enum UploadStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
}
