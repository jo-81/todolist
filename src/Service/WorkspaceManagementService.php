<?php

namespace App\Service;

use App\Entity\Workspace;
use Doctrine\ORM\EntityManagerInterface;

class WorkspaceManagementService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function persist(Workspace $workspace): void
    {
        $this->em->persist($workspace);
        $this->em->flush();
    }

    public function remove(Workspace $workspace): void
    {
        $this->em->remove($workspace);
        $this->em->flush();
    }
}
