<?php

namespace App\Twig\Components\Workspace;

use App\Entity\Workspace;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Card
{
    public Workspace $workspace;
}
