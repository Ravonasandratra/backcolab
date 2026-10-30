<?php
namespace App\Service;

use App\Entity\TokenPasswordReset;
use Doctrine\ORM\EntityManagerInterface;

class ServiceTokenPasswordReset {
    function __construct(private readonly EntityManagerInterface $entity)
    {
    }
    public function generateToken(int $id): String {
        $token = bin2hex(random_bytes(32));
        
        $tokenPasswordReset = new TokenPasswordReset();
        $tokenPasswordReset->setUser($id);
        $tokenPasswordReset->setHashToken(hash("sha256", $token));
        $tokenPasswordReset->setExpiredAt(new \DateTimeImmutable("+5 munite"));

        $this->entity->persist($tokenPasswordReset);
        $this->entity->flush();

        return $token;
    }
}