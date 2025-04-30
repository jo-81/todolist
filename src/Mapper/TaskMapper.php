<?php

namespace App\Mapper;

use App\Entity\Task;
use App\DTO\Task\TaskUpdatedDTO;
use App\DTO\Task\TaskRegisterDTO;

class TaskMapper
{
    public static function toUpdatedTaskDTO(Task $task): TaskUpdatedDTO
    {
        $dto = new TaskUpdatedDTO();
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

    public static function taskFromRegisterDTO(TaskRegisterDTO $taskRegisterDTO, ?Task $task = null)
    {
        $entity = $task ?? new Task();
        $entity
            ->setTitle($taskRegisterDTO->getTitle())
            ->setContent($taskRegisterDTO->getContent())
            ->setLimitedAt($taskRegisterDTO->getLimitedAt())
            ->setPriority($taskRegisterDTO->getPriority())
        ;

        return $entity;
    }

    public static function taskFromUpdatedDTO(TaskUpdatedDTO $taskUpdatedDTO, ?Task $task = null)
    {
        $entity = $task ?? new Task();
        $entity
            ->setTitle($taskUpdatedDTO->getTitle())
            ->setContent($taskUpdatedDTO->getContent())
            ->setLimitedAt($taskUpdatedDTO->getLimitedAt())
            ->setPriority($taskUpdatedDTO->getPriority())
            ->setStatus($taskUpdatedDTO->getStatus())
            ->setArchived($taskUpdatedDTO->isArchived())
            ->setCompleted($taskUpdatedDTO->isCompleted())
        ;

        return $entity;
    }
}
