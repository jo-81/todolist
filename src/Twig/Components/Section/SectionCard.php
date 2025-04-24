<?php

namespace App\Twig\Components\Section;

use App\Entity\Section;
use App\Service\SectionService;
use App\Repository\TaskRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class SectionCard
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public bool $isVisible = false;

    #[LiveProp()]
    public bool $isVisibleUpdatedForm = false;

    public function __construct(
        private SectionService $sectionService,
        private TaskRepository $taskRepository,
    ) {
    }

    #[LiveProp()]
    public Section $section;

    #[LiveAction]
    public function getNumberTasks()
    {
        return $this->taskRepository->count(['section' => $this->section]);
    }

    #[LiveAction]
    public function remove()
    {
        $this->sectionService->remove($this->section);
        $this->emit('section:remove');
    }

    #[LiveAction]
    public function toggleVisibility()
    {
        $this->isVisible = !$this->isVisible;
    }

    #[LiveAction]
    public function toggleVisibilityUpdatedForm()
    {
        $this->isVisibleUpdatedForm = !$this->isVisibleUpdatedForm;
    }

    #[LiveListener('section:updated')]
    public function toggleVisibilityUpdatedFormWhenUpdated()
    {
        $this->isVisibleUpdatedForm = false;
    }
}
