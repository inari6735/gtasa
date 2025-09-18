<?php declare(strict_types=1);

namespace App\Shared;

use App\Shared\Entity\User;
use App\Shared\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Context
{
    private ?User $user = null;

    public function __construct(
        private readonly TokenStorageInterface $token,
        private readonly UserRepository $userRepository,
    )
    {
        $this->setUser();
    }

    public function getUser(): User | null
    {
        return $this->user;
    }

    private function setUser(): void
    {
        $token = $this->token->getToken();
        if (!$token) {
            return;
        }

        $identifier = $token->getUser()->getUserIdentifier();
        $this->user = $this->userRepository->findByIdentifier($identifier);
    }
}
