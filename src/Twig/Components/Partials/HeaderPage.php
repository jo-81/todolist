<?php

namespace App\Twig\Components\Partials;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class HeaderPage
{
    public string $title;
}
