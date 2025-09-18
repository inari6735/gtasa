<?php declare(strict_types=1);

namespace App\Media\Model\DTO;

use App\Media\Model\Enum\MediaVisibility;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaInput
{
    public ?UploadedFile $file = null;
    public MediaVisibility $visibility = MediaVisibility::PRIVATE;
}
