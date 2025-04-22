<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class DynamicContent
{
    use DefaultActionTrait;

    #[LiveProp()]
    public bool $isVisible = false;

    #[LiveAction]
    public function toggleVisibility(): void
    {
        $this->isVisible = !$this->isVisible;
    }

    #[LiveListener('section:register')]
    public function close()
    {
        $this->isVisible = false;
    }
}
