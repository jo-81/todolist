<?php

namespace App\Mapper;

use App\Entity\Task;
use App\DTO\Task\TaskDTO;

class TaskMapper
{
    public static function toTaskDTO(Task $task): TaskDTO
    {
        $dto = new TaskDTO();
        $dto
            ->setTitle($task->getTitle())
            ->setContent($task->getContent())
            ->setLimitedAt($task->getLimitedAt())
            ->setStatus($task->getStatus())
            ->setPriority($task->getPriority())
            ->setArchived($task->isArchived())
            ->setCompleted($task->isCompleted())
        ;

        return $dto;
    }
}
