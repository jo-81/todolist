<?php

namespace App\Mapper;

use App\Entity\Section;
use App\DTO\Section\SectionDTO;

class SectionMapper
{
    public static function toSectionDTO(Section $section): SectionDTO
    {
        $dto = new SectionDTO();
        $dto
            ->setName($section->getName())
            ->setDescription($section->getDescription())
        ;

        return $dto;
    }

    public static function sectionFromDTO(SectionDTO $dto, ?Section $section = null): Section
    {
        $entity = $section ?? new Section();
        $entity
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
        ;

        return $entity;
    }
}
