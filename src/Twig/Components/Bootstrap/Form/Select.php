<?php

namespace App\Twig\Components\Bootstrap\Form;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Select
{
    public string $name;

    public string $method;

    public array $options = [];
}
