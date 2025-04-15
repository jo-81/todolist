<?php

namespace App\Twig\Components\Trait;

use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait QueryTrait
{
    #[LiveProp(writable: true, url: true)]
    public string $query = '';
}
