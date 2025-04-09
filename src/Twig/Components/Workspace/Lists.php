<?php

namespace App\Twig\Components\Workspace;

use App\Repository\WorkspaceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class Lists
{
    use DefaultActionTrait;

    public const NUMBER_ITEMS = 2;

    #[LiveProp(writable: true, url: true)]
    public int $page = 1;

    #[LiveProp(writable: true, url: true)]
    public string $query = '';

    public function __construct(
        private WorkspaceRepository $workspaceRepository,
        private PaginatorInterface $paginator,
        private Security $security,
    ) {
    }

    public function getWorkspaces(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->workspaceRepository->findWorkspaceQuery($this->security->getUser(), $this->query),
            $this->page,
            self::NUMBER_ITEMS
        );
    }

    #[LiveAction]
    public function nextPage(): void
    {
        $this->page = max(1, $this->page + 1);
    }

    #[LiveAction]
    public function prevPage(): void
    {
        $this->page = max(1, $this->page - 1);
    }

    #[LiveAction]
    public function selectedPage(#[LiveArg] int $page): void
    {
        $this->page = $page;
    }
}
