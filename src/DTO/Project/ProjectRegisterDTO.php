<?php

namespace App\DTO\Project;

use App\Validator\Constraints\NameConstraint;
use App\Validator\Constraints\DescriptionConstraint;

class ProjectRegisterDTO
{
    #[NameConstraint]
    private string $name;

    #[DescriptionConstraint]
    private ?string $description;

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