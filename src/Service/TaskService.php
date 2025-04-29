<?php

namespace App\Service;

use App\Entity\Task;
use App\Enum\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class TaskService
{
    public function __construct(private EntityManagerInterface $em, private HtmlSanitizerInterface $htmlSanitizer)
    {
    }

    public function register(Task $task)
    {
        $task->setArchived(false);
        $task->setStatus(Status::TODO);

        $content = $task->getContent();
        if (!is_null($content)) {
            $task->setContent($this->sanitizepropertyContent($content));
        }

        $this->em->persist($task);
        $this->em->flush();
    }

    public function remove(Task $task)
    {
        $this->em->remove($task);
        $this->em->flush();
    }

    private function sanitizepropertyContent(string $content): string
    {
        return $this->htmlSanitizer->sanitize($content);
    }
}
