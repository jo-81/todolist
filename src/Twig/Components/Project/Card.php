<?php

namespace App\Twig\Components\Project;

use App\Entity\Project;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Card
{
    public Project $project;
}
