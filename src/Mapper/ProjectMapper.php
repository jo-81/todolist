<?php

namespace App\Mapper;

use App\Entity\Project;
use App\DTO\Project\ProjectDTO;

class ProjectMapper
{
    public static function projectFromDTO(ProjectDTO $dto, ?Project $project = null): Project
    {
        $entity = $project ?? new Project();
        $entity
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setArchived($dto->isArchived())
        ;

        return $entity;
    }

    public static function toProjectDTO(Project $project): ProjectDTO
    {
        $dto = new ProjectDTO();
        $dto
            ->setName($project->getName())
            ->setDescription($project->getDescription())
            ->setArchived($project->isArchived());
        ;

        return $dto;
    }
}
