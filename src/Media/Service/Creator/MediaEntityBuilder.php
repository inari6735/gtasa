<?php declare(strict_types=1);

namespace App\Media\Service\Creator;

use App\Media\Model\Enum\MediaVisibility;
use App\Media\Model\ValueObject\Extension;
use App\Media\Model\ValueObject\Filename;
use App\Media\Model\ValueObject\Filesize;
use App\Media\Model\ValueObject\MimeType;
use App\Media\Model\ValueObject\Path;
use App\Media\Model\ValueObject\Url;
use App\Shared\Entity\Media;
use App\Shared\Entity\User;

class MediaEntityBuilder
{
    public function build(
        Url $url,
        Filename $filename,
        Filename $originalFilename,
        Path $relativePath,
        MimeType $mimeType,
        Extension $extension,
        Filesize $filesize,
        MediaVisibility $visibility,
        User $user,
    ): Media
    {
        return new Media()
            ->setUrl($url->value())
            ->setFilename($filename->value())
            ->setOriginalFilename($originalFilename->value())
            ->setPath($relativePath->value())
            ->setMimeType($mimeType->value())
            ->setExtension($extension->value())
            ->setFilesize($filesize->value())
            ->setVisibility($visibility->value)
            ->setUser($user)
        ;
    }
}
