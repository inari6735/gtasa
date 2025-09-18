<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class Filesize
{
    private int $filesize = 0;
    private function __construct(
        ?int $filesize
    )
    {
        if ($filesize) {
            $this->filesize = $filesize;
        }
    }

    public static function create(?int $filesize): self
    {
        return new self($filesize);
    }

    public function value(): int
    {
        return $this->filesize;
    }
}
