<?php declare(strict_types=1);

namespace App\Media\Config;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;
use function Symfony\Component\String\u;

readonly class FilenameProcessor
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}
    public static function create(?string $extension): string
    {
        $unique = Uuid::v4()->toBase32();

        return u($unique)->lower()->toString() . ($extension ? '.' . $extension : '');
    }

    public function safeFilename(string $filename): string
    {
        return $this->slugger->slug($filename)->toString();
    }
}
