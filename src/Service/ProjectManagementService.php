<?php

namespace App\Service;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManagementService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function register(Project $project): void
    {
        $project->setArchived(false);

        $this->em->persist($project);
        $this->em->flush();
    }
}
