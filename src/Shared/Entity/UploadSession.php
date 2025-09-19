<?php declare(strict_types=1);

namespace App\Shared\Entity;

use App\Media\Model\Enum\UploadStatus;
use App\Shared\Repository\UploadSessionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UploadSessionRepository::class)]
#[ORM\Table(name: 'upload_session')]
#[ORM\HasLifecycleCallbacks]
class UploadSession
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null $user = null;

    #[ORM\Column(length: 128)]
    private string $fingerprint;

    #[ORM\Column(name: 'filename', length: 200)]
    private string $filename = '';

    #[ORM\Column(name: 'received_chunks', type: 'integer')]
    private int $receivedChunks = 0;

    #[ORM\Column(name: 'total_chunks', type: 'integer')]
    private int $totalChunks;

    #[ORM\Column(name: 'chunk_size', type: 'bigint')]
    private int $chunkSize;

    #[ORM\Column(name: 'size', type: 'bigint')]
    private int $filesize = 0;

    #[Orm\Column(name: 'mime_type', length: 100)]
    private string $mimeType = '';

    #[Orm\Column(name: 'extension', length: 20)]
    private string $extension = '';

    #[ORM\Column(name: 'status', length: 30)]
    private string $status = UploadStatus::ACTIVE->value;

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

    public function setUser(?User $user): UploadSession
    {
        $this->user = $user;
        return $this;
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    public function setFingerprint(string $fingerprint): UploadSession
    {
        $this->fingerprint = $fingerprint;
        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): UploadSession
    {
        $this->filename = $filename;
        return $this;
    }

    public function getReceivedChunks(): int
    {
        return $this->receivedChunks;
    }

    public function setReceivedChunks(int $receivedChunks): UploadSession
    {
        $this->receivedChunks = $receivedChunks;
        return $this;
    }

    public function getTotalChunks(): int
    {
        return $this->totalChunks;
    }

    public function setTotalChunks(int $totalChunks): UploadSession
    {
        $this->totalChunks = $totalChunks;
        return $this;
    }

    public function getFilesize(): int
    {
        return $this->filesize;
    }

    public function setFilesize(int $filesize): UploadSession
    {
        $this->filesize = $filesize;
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

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;
        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): UploadSession
    {
        $this->status = $status;
        return $this;
    }

    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }

    public function setChunkSize(int $chunkSize): UploadSession
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }
}
