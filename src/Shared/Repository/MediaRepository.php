<?php declare(strict_types=1);

namespace App\Shared\Repository;

use App\Shared\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function save(Media $media, $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($media);

        if ($flush) {
            $em->flush();
        }
    }

    public function delete(Media $media, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->remove($media);

        if ($flush) {
            $em->flush();
        }
    }
}
