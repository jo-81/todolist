<?php

namespace App\Twig\Components\Project;

use App\Entity\Workspace;
use App\Repository\ProjectRepository;
use App\Twig\Components\Trait\QueryTrait;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Trait\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class Lists
{
    use DefaultActionTrait;
    use PaginationTrait;
    use QueryTrait;

    public const NUMBER_ITEMS = 2;

    #[LiveProp(writable: true)]
    public Workspace $workspace;

    #[LiveProp(writable: true, url: true)]
    public int $archived = -1;

    public function __construct(
        private ProjectRepository $projectRepository,
        private PaginatorInterface $paginator,
    ) {
    }

    public function getProjects()
    {
        return $this->paginator->paginate(
            $this->projectRepository->findProjectsQuery($this->workspace, $this->query, $this->archived),
            $this->page,
            self::NUMBER_ITEMS
        );
    }
}
