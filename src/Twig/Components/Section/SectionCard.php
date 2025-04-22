<?php

namespace App\Twig\Components\Section;

use App\Entity\Section;
use App\Service\SectionService;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
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

    public function __construct(private SectionService $sectionService)
    {
    }

    #[LiveProp()]
    public Section $section;

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
}
