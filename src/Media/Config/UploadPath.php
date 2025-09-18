<?php declare(strict_types=1);

namespace App\Media\Config;

class UploadPath
{
    public const string MEDIA = "/media";
    public const string IMAGES = "/media/images";

    public static function userMediaPath(string $userId, string $filename): string
    {
        return static::MEDIA . "/" . $userId . "/media/" . $filename;
    }
}
