<?php

namespace App\Twig\Components\Label;

use App\Entity\Task;
use App\Repository\LabelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[IsGranted("ROLE_USER")]
#[AsLiveComponent]
final class LabelList
{
    use DefaultActionTrait;

    public int $numberItems = 5;

    #[LiveProp()]
    public int $page = 1;

    #[LiveProp()]
    public Task $task;

    public function __construct(private LabelRepository $labelRepository, private PaginatorInterface $paginator,)
    {}

    public function getLabels()
    {
        $limit = $this->page <= 0 ? $this->numberItems : $this->page * $this->numberItems;
        return $this->paginator->paginate(
            $this->labelRepository->findLabelsByTask($this->task),
            1,
            $limit
        );
    }

    public function displayItems()
    {
        return $this->numberItems * $this->page;
    }

    #[LiveAction]
    public function nextPage()
    {
        $this->page++;
    }

    #[LiveAction]
    public function prevPage()
    {
        $this->page--;
    }
}
