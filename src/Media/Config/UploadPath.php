<?php declare(strict_types=1);

namespace App\Media\Config;

readonly class UploadPath
{
    public const string MEDIA = "/media";
    public const string IMAGES = "/media/images";

    public function __construct(
        private string $projectDir
    ) {}

    public static function userMediaPath(string $userId, string $filename): string
    {
        return static::MEDIA . "/" . $userId . "/media/" . $filename;
    }

    public static function chunkPath(string $uploadId, string $chunkName): string
    {
        return '/' . $uploadId . "/" . $chunkName;
    }

    public function getTempDir(): string
    {
        return realpath($this->projectDir . '/var/storage/uploads/temp')
            ?: $this->projectDir . '/var/storage/uploads/temp';
    }
}
