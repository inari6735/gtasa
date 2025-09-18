<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class Filename
{
    private string $filename = '';
    private function __construct(
        ?string $filename
    )
    {
        if ($filename) {
            $this->filename = $filename;
        }
    }

    public static function create(?string $filename): self
    {
        return new self($filename);
    }

    public function value(): string
    {
        return $this->filename;
    }
}
