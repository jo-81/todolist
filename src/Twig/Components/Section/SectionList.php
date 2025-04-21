<?php

namespace App\Twig\Components\Section;

use App\Entity\Project;
use App\Entity\Section;
use App\Repository\SectionRepository;
use App\Twig\Components\Trait\QueryTrait;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class SectionList extends AbstractController
{
    use DefaultActionTrait;
    use QueryTrait;

    #[LiveProp()]
    public Project $project;

    public function __construct(
        private SectionRepository $sectionRepository,
        private CacheInterface $cache,
    ) {
    }
    
    /**
     * getSections
     *
     * @return Section[]
     */
    public function getSections()
    {
        return $this->cache->get(
            sprintf('section_list_%d', $this->project->getId()),
            function () {
                return $this->sectionRepository->findSectionsQuery($this->project, $this->query);
            }
        );
    }
}
