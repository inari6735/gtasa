<?php declare(strict_types=1);

namespace App\MediaHandling\Domain\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'media')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class MediaORM
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $id = null;

    #[ORM\Column(name: "url", length: 2000)]
    private ?string $url = null;

    #[Orm\Column(name: 'filename', length: 200)]
    private ?string $filename = null;

    #[Orm\Column(name: 'original_filename', length: 200)]
    private ?string $originalFilename = null;

    #[Orm\Column(name: 'relative_path', length: 1000)]
    private ?string $relativePath = null;

    #[Orm\Column(name: 'mime_type', length: 20)]
    private ?string $mimeType = null;

    #[Orm\Column(name: 'extension', length: 20)]
    private ?string $extension = null;

    #[Orm\Column(name: 'size')]
    private ?int $filesize = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private DateTimeInterface $updatedAt;

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }
    public function setMimeType(string $mimeType): static
    {
        $this->mimeType = $mimeType;

        return $this;
    }
    public function getFilename(): ?string
    {
        return $this->filename;
    }
    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }
    public function getUrl(): ?string
    {
        return $this->url;
    }
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setRelativePath(?string $relativePath): MediaORM
    {
        $this->relativePath = $relativePath;
        return $this;
    }

    public function getRelativePath(): ?string
    {
        return $this->relativePath;
    }

    public function setOriginalFilename(?string $originalFilename): MediaORM
    {
        $this->originalFilename = $originalFilename;
        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setExtension(?string $extension): MediaORM
    {
        $this->extension = $extension;
        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setFilesize(?int $filesize): MediaORM
    {
        $this->filesize = $filesize;
        return $this;
    }

    public function getFilesize(): ?int
    {
        return $this->filesize;
    }
}
