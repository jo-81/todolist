<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class TaskCard
{
    use DefaultActionTrait;

    #[LiveProp()]
    public Task $task;
}
