<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use App\Mapper\TaskMapper;
use App\Service\TaskService;
use App\DTO\Task\TaskUpdatedDTO;
use App\Form\Task\TaskUpdatedType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class TaskUpdatedForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public Task $task;

    #[LiveProp(writable: true)]
    public TaskUpdatedDTO $initialFormData;

    public function __construct(private TaskService $taskService)
    {
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        if (!isset($data['task'])) {
            return $data;
        }

        $this->initialFormData = TaskMapper::toUpdatedTaskDTO($data['task']);

        return $data;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TaskUpdatedType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /** @var Task */
            $task = TaskMapper::taskFromUpdatedDTO($this->getForm()->getData(), $this->task);
            $this->taskService->updated($task);

            $this->emit('task:updated');

            $this->resetForm();
        }
    }
}
