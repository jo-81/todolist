<?php

namespace App\Mapper;

use App\Entity\Project;
use App\DTO\Project\ProjectRegisterDTO;

class ProjectMapper
{
    public static function projectFromRegisterDTO(ProjectRegisterDTO $dto, ?Project $project = null): Project
    {
        $entity = $project ?? new Project();
        $entity
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
        ;

        return $entity;
    }
}
