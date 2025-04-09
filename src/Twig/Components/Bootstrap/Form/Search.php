<?php

namespace App\Twig\Components\Bootstrap\Form;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Search
{
    public string $placeholder = '';
}
