<?php

namespace App\DTO\Task;

use App\Enum\Status;
use App\Enum\Priority;
use DateTimeImmutable;

class TaskDTO
{
    private string $title;

    private ?string $content = null;

    private ?DateTimeImmutable $limitedAt = null;

    private Status $status;

    private Priority $priority;

    private bool $archived;

    private bool $completed;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getLimitedAt(): ?DateTimeImmutable
    {
        return $this->limitedAt;
    }

    public function setLimitedAt(?DateTimeImmutable $limitedAt): static
    {
        $this->limitedAt = $limitedAt;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): static
    {
        $this->priority = $priority;

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

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }
}