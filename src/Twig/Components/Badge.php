<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Badge
{
    public string $type = 'primary';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['type' => 'primary']);
        $resolver->setAllowedValues('type', ['success', 'danger', 'info', 'warning', 'secondary', 'primary']);

        return $resolver->resolve($data) + $data;
    }
}
