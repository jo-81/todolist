<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use App\Service\TaskService;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class TaskCard
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public Task $task;

    #[LiveProp()]
    public bool $isDisplayUpdatedForm = false;

    #[LiveProp()]
    public bool $isDisplayRemoveCard = false;

    public function __construct(private TaskService $taskService)
    {
    }

    #[LiveAction]
    public function toggleDisplayUpdatedForm()
    {
        $this->isDisplayUpdatedForm = !$this->isDisplayUpdatedForm;
    }

    #[LiveAction]
    public function toggleDisplayRemoveCard()
    {
        $this->isDisplayRemoveCard = !$this->isDisplayRemoveCard;
    }

    #[LiveAction]
    public function remove()
    {
        $this->taskService->remove($this->task);

        $this->isDisplayRemoveCard = false;

        $this->emitUp('task:removed');
    }

    #[LiveListener('task:updated')]
    public function updated()
    {
        $this->isDisplayUpdatedForm = false;
    }
}
