<?php

namespace App\Twig\Components\Section;

use App\Entity\Project;
use App\Entity\Section;
use App\Repository\SectionRepository;
use App\Twig\Components\Trait\QueryTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class SectionList
{
    use DefaultActionTrait;
    use QueryTrait;

    #[LiveProp()]
    public Project $project;

    public function __construct(
        private SectionRepository $sectionRepository,
    ) {
    }

    /**
     * getSections.
     *
     * @return Section[]
     */
    public function getSections()
    {
        return $this->sectionRepository->findSectionsQuery($this->project, $this->query);
    }

    #[LiveListener('section:remove')]
    public function refreshList()
    {
    }
}
