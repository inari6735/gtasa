<?php declare(strict_types=1);

namespace App\Media\Model\Entity;

class Chunk
{
    public const int CHUNK_SIZE = 52428800; // 50MB

    public static function calculateTotalChunks(int $filesize): int
    {
        if ($filesize <= 0) {
            return 1;
        }

        return (int) ceil($filesize / self::CHUNK_SIZE);
    }
}
