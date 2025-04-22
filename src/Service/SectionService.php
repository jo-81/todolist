<?php

namespace App\Service;

use App\Entity\Section;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SectionService
{
    public function __construct(private EntityManagerInterface $em, private SectionRepository $sectionRepository)
    {
    }

    public function persist(Section $section)
    {
        $position = $this->sectionRepository->count(['project' => $section->getProject()]);
        $section->setPosition($position + 1);

        $this->em->persist($section);
        $this->em->flush();
    }
}
