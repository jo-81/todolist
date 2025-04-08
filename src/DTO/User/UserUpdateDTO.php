<?php

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

final class UserUpdateDTO
{
    #[Assert\NotBlank(message: 'Votre adresse email ne peut pas être vide.')]
    #[Assert\Email(message: "Votre adresse email n'est pas au bon format.")]
    private ?string $email = null;

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
