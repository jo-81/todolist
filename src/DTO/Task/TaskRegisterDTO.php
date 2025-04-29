<?php

namespace App\DTO\Task;

use App\Enum\Priority;
use Symfony\Component\Validator\Constraints as Assert;

class TaskRegisterDTO
{
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern: '/<(script|iframe|img)[^>]*>|on\w+\s*=/i',
        match: false,
        message: 'Le contenu contient des éléments non autorisés.',
    )]
    private string $title;

    private ?string $content = null;

    #[Assert\When(
        expression: 'value != null',
        constraints: [
            new Assert\DateTime(),
            new Assert\LessThan('today', message: "La date doit être antérieure à aujourd'hui."),
        ]
    )]
    private ?\DateTimeImmutable $limitedAt = null;

    #[Assert\Type(
        type: Priority::class,
        message: 'La valeur doit être un cas valide de '.Priority::class
    )]
    private Priority $priority;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getLimitedAt(): ?\DateTimeImmutable
    {
        return $this->limitedAt;
    }

    public function setLimitedAt(?\DateTimeImmutable $limitedAt): static
    {
        $this->limitedAt = $limitedAt;

        return $this;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
