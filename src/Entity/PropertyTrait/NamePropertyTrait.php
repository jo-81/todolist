<?php

namespace App\Entity\PropertyTrait;

use Doctrine\ORM\Mapping as ORM;

trait NamePropertyTrait
{
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}