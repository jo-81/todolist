<?php

namespace App\Tests\Trait;

use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidationErrorTrait
{
    public function getValidationErrors(object $entity, ValidatorInterface $validator): array
    {
        $errors = $validator->validate($entity);

        $errorMessages = [];
        foreach ($errors as $violation) {
            $errorMessages[] = sprintf('%s', $violation->getMessage());
        }

        return [
            'count' => count($errors),
            'messages' => $errorMessages,
        ];
    }
}
