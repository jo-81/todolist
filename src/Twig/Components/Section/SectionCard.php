<?php

namespace App\Twig\Components\Section;

use App\Entity\Section;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class SectionCard
{
    #[LiveProp()]
    public Section $section;
}
