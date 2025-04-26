<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatableInterface;

enum Status: string implements TranslatableInterface
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in progress';
    case DONE = 'done';

    public function getIcon(): string
    {
        return match ($this) {
            self::TODO => 'tabler:antenna-bars-1',
            self::IN_PROGRESS => 'tabler:antenna-bars-3',
            self::DONE => 'tabler:antenna-bars-5',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TODO => 'danger',
            self::IN_PROGRESS => 'warning',
            self::DONE => 'success',
        };
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        // Translate enum from name (Left, Center or Right)
        // return $translator->trans($this->name, locale: $locale);

        // Translate enum using custom labels
        return match ($this) {
            self::TODO  => $translator->trans('A faire', locale: $locale),
            self::IN_PROGRESS => $translator->trans('En cours', locale: $locale),
            self::DONE  => $translator->trans('Terminée', locale: $locale),
        };
    }
}
