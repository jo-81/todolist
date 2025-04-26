<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use App\DTO\Task\TaskDTO;
use App\Mapper\TaskMapper;
use App\Form\Task\TaskType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class TaskUpdatedForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public Task $task;

    #[LiveProp(writable: true)]
    public TaskDTO $initialFormData;

    #[PreMount]
    public function preMount(array $data): array
    {
        if (!isset($data['task'])) {
            return $data;
        }

        $this->initialFormData = TaskMapper::toTaskDTO($data['task']);

        return $data;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TaskType::class, $this->initialFormData);
    }
}
