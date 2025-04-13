<?php

namespace App\DTO\Workspace;

use Symfony\Component\Validator\Constraints as Assert;

final class WorkspaceDTO
{
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'Ce champ doit contenir un minimum de {{ limit }} caractères.',
        maxMessage: 'Ce champ ne peut pas contenir plus de {{ limit }} caractères.',
    )]
    #[Assert\Regex([
        'pattern' => '/<(script|iframe|img)[^>]*>|on\w+\s*=/i',
        'match' => false,
        'message' => 'Le contenu contient des éléments non autorisés.',
    ]),]
    private string $name;

    #[Assert\When([
        'expression' => 'value != null',
        'constraints' => [
            new Assert\NoSuspiciousCharacters(),
            new Assert\Length([
                'max' => 400,
                'maxMessage' => 'Le texte ne doit pas dépasser {{ limit }} caractères.',
            ]),
            new Assert\Regex([
                'pattern' => '/<(script|iframe|img)[^>]*>|on\w+\s*=/i',
                'match' => false,
                'message' => 'Le contenu contient des éléments non autorisés.',
            ]),
            new Assert\Type(
                type: 'string',
                message: 'Le contenu doit être une chaîne de caractères.'
            ),
        ],
    ])]
    private ?string $description = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
