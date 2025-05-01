<?php

namespace App\Twig\Components\Label;

use App\Entity\Label;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
#[AsTwigComponent]
final class LabelCard
{
    public Label $label;
}
