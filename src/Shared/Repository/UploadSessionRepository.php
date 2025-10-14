<?php

declare(strict_types=1);

namespace App\Shared\Repository;

use App\Media\Model\Enum\UploadStatus;
use App\Shared\Entity\UploadSession;
use App\Shared\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class UploadSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadSession::class);
    }

    public function findById(string $id): ?UploadSession
    {
        $dql = <<<DQL
            SELECT s
            FROM App\Shared\Entity\UploadSession s
            WHERE s.id = :id
        DQL;

        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('id', Uuid::fromString($id), 'uuid');

        return $query->getOneOrNullResult();
    }

    public function findActiveByFingerprint(string $userId, string $fingerprint): ?UploadSession
    {
        $uploadSession = null;
        $dql = <<<DQL
            SELECT s
            FROM App\Shared\Entity\UploadSession s
            WHERE s.fingerprint = :fingerprint
            AND s.status = :status
        DQL;

        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('fingerprint', $fingerprint)
            ->setParameter('status', UploadStatus::ACTIVE->value);
        $results = $query->getResult();
        if (empty($results)) {
            return null;
        }

        /**
         * @var UploadSession $result
         */
        foreach ($results as $result) {
            if ($result->getUser()->getId() === $userId) {
                $uploadSession = $result;
                break;
            }
        }

        return $uploadSession;
    }

    public function save(UploadSession $uploadSession, $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($uploadSession);

        if ($flush) {
            $em->flush();
        }
    }

    public function delete(UploadSession $uploadSession, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->remove($uploadSession);

        if ($flush) {
            $em->flush();
        }
    }
}
