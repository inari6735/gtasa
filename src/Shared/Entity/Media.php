<?php declare(strict_types=1);

namespace App\Shared\Entity;

use App\Media\Model\Enum\MediaVisibility;
use App\Shared\Repository\MediaRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\Table(name: 'media')]
#[ORM\HasLifecycleCallbacks]
class Media
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null $user = null;

    #[ORM\Column(name: "url", length: 2000, nullable: true)]
    private ?string $url = null;

    #[Orm\Column(name: 'filename', length: 200)]
    private string $filename = '';

    #[Orm\Column(name: 'original_filename', length: 200)]
    private string $originalFilename = '';

    #[Orm\Column(name: 'path', length: 1000)]
    private string $path = '';

    #[Orm\Column(name: 'mime_type', length: 20)]
    private string $mimeType = '';

    #[Orm\Column(name: 'extension', length: 20)]
    private string $extension = '';

    #[Orm\Column(name: 'size')]
    private int $filesize = 0;

    #[Orm\Column(name: 'visibility')]
    private string $visibility = MediaVisibility::PRIVATE->value;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Media
    {
        $this->user = $user;
        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
    public function setMimeType(string $mimeType): static
    {
        $this->mimeType = $mimeType;

        return $this;
    }
    public function getFilename(): string
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
    public function setUrl(?string $url): static
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

    public function setPath(string $path): Media
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setOriginalFilename(string $originalFilename): Media
    {
        $this->originalFilename = $originalFilename;
        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setExtension(string $extension): Media
    {
        $this->extension = $extension;
        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setFilesize(int $filesize): Media
    {
        $this->filesize = $filesize;
        return $this;
    }

    public function getFilesize(): int
    {
        return $this->filesize;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): Media
    {
        $this->visibility = $visibility;
        return $this;
    }
}
