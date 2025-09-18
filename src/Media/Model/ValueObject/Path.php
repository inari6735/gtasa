<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class Path
{
    private string $path;
    private function __construct(
        string $path
    )
    {
        $this->path = $path;
    }

    public static function create(string $path): self
    {
        return new self($path);
    }

    public function value(): string
    {
        return $this->path;
    }
}
