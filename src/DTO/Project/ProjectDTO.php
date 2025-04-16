<?php

namespace App\DTO\Project;

use App\Validator\Constraints\NameConstraint;
use App\Validator\Constraints\DescriptionConstraint;

class ProjectDTO
{
    #[NameConstraint]
    private string $name;

    #[DescriptionConstraint]
    private ?string $description = null;

    private bool $archived;

    public function __construct()
    {
        $this->archived = false;
    }

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

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }
}