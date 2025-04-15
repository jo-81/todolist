<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

#[\Attribute]
class DescriptionConstraint extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\When([
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
            ])
        ];
    }
}