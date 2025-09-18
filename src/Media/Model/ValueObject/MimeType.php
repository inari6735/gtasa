<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class MimeType
{
    private string $mimeType = '';
    private function __construct(
        ?string $mimeType
    )
    {
        if ($mimeType) {
            $this->mimeType = $mimeType;
        }
    }

    public static function create(?string $mimeType): self
    {
        return new self($mimeType);
    }

    public function value(): string
    {
        return $this->mimeType;
    }
}
