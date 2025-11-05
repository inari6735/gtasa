<?php

declare(strict_types=1);

namespace App\Shared\Entity;

use App\Shared\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'image')]
#[ORM\HasLifecycleCallbacks]
class Image
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $id = null;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    #[ORM\JoinColumn(name: 'media_id', referencedColumnName: 'id')]
    private Media|null $media = null;
}
