<?php

declare(strict_types=1);

namespace App\Media\Config;

class Fingerprint
{
    public static function create(string $userId, string $filename, int $fileSize, \DateTimeInterface|null $fileLastModified): string
    {
        $size = (string) $fileSize;
        $mtime = 0;

        if ($fileLastModified instanceof \DateTimeInterface) {
            $mtime = $fileLastModified->format('U');
        }

        $raw = implode('|', [$userId, $filename, $size, $mtime]);

        return hash('sha256', $raw);
    }
}
