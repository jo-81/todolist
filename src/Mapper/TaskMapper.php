<?php

namespace App\Mapper;

use App\Entity\Task;
use App\DTO\Task\TaskDTO;
use App\DTO\Task\TaskRegisterDTO;

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
}
