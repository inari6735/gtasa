<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class Extension
{
    private string $extension = '';
    private function __construct(
        ?string $extension
    )
    {
        if ($extension) {
            $this->extension = $extension;
        }
    }

    public static function create(?string $extension): self
    {
        return new self($extension);
    }

    public function value(): string
    {
        return $this->extension;
    }
}
