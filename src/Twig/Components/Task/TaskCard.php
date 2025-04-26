<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class TaskCard
{
    use DefaultActionTrait;

    #[LiveProp()]
    public Task $task;

    #[LiveProp()]
    public bool $isDisplayUpdatedForm = false;

    #[LiveAction]
    public function toggleDisplayUpdatedForm()
    {
        $this->isDisplayUpdatedForm = !$this->isDisplayUpdatedForm;
    }
}
