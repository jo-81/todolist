<?php

namespace App\DTO\Section;

use App\Validator\Constraints\NameConstraint;
use App\Validator\Constraints\DescriptionConstraint;

class SectionDTO
{
    #[NameConstraint]
    private string $name;

    #[DescriptionConstraint]
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
