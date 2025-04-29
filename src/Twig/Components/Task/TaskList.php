<?php

namespace App\Twig\Components\Task;

use App\Entity\Section;
use App\Repository\TaskRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class TaskList
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public Section $section;

    #[LiveProp(writable: true)]
    public string $status = '';

    #[LiveProp(writable: true)]
    public string $priority = '';

    #[LiveProp(writable: true)]
    public int $archived = -1;

    #[LiveProp(writable: true)]
    public int $completed = -1;

    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function getTasks()
    {
        return $this->taskRepository->filterListTasks(
            $this->section,
            $this->status,
            $this->priority,
            $this->archived,
            $this->completed
        );
    }

    #[LiveListener('task:created')]
    public function refreshAfterTaskCreated()
    {
    }
}
