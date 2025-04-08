<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManagementService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function updateEntity(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
