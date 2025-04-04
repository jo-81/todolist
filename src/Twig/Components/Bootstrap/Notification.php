<?php

namespace App\Twig\Components\Bootstrap;

use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class Notification
{
    public string $type = 'success';

    public string $message = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['type' => 'success']);
        $resolver->setAllowedValues('type', ['success', 'danger', 'info', 'warning']);
        $resolver->setRequired('message');
        $resolver->setAllowedTypes('message', 'string');

        return $resolver->resolve($data) + $data;
    }
}