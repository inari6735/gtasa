<?php declare(strict_types=1);

namespace App\Media\Model\ValueObject;

class Url
{
    private ?string $url;
    private function __construct(
        ?string $url
    )
    {
        $this->url = $url;
    }

    public static function create(?string $url): self
    {
        return new self($url);
    }

    public function value(): string | null
    {
        return $this->url;
    }
}
