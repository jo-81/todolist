<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

#[\Attribute]
class NameConstraint extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(message: 'Ce champ ne peut pas être vide.'),
            new Assert\NoSuspiciousCharacters(),
            new Assert\Length(
                min: 3,
                max: 20,
                minMessage: 'Ce champ doit contenir un minimum de {{ limit }} caractères.',
                maxMessage: 'Ce champ ne peut pas contenir plus de {{ limit }} caractères.',
            ),
            new Assert\Regex([
                'pattern' => '/<(script|iframe|img)[^>]*>|on\w+\s*=/i',
                'match' => false,
                'message' => 'Le contenu contient des éléments non autorisés.',
            ]),
        ];
    }
}
