<?php

namespace App\Mapper;

use App\Entity\Workspace;
use App\DTO\Workspace\WorkspaceDTO;

class WorkspaceMapper
{
    public static function toWorkspaceDTO(Workspace $workspace): WorkspaceDTO
    {
        $dto = new WorkspaceDTO();
        $dto
            ->setName($workspace->getName())
            ->setDescription($workspace->getDescription())
        ;

        return $dto;
    }

    public static function workspaceFromDTO(WorkspaceDTO $dto): Workspace
    {
        $workspace = new Workspace();
        $workspace
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
        ;

        return $workspace;
    }
}
