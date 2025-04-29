<?php

namespace App\Twig\Components\Task;

use App\Entity\Task;
use App\Entity\Section;
use App\Mapper\TaskMapper;
use App\Service\TaskService;
use App\DTO\Task\TaskRegisterDTO;
use App\Form\Task\TaskRegisterType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class TaskRegisterForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public bool $isDisplayForm = false;

    #[LiveProp(writable: true)]
    public ?TaskRegisterDTO $initialFormData = null;

    #[LiveProp()]
    public Section $section;

    public function __construct(private TaskService $taskService)
    {
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TaskRegisterType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function toggleDisplayForm(): void
    {
        $this->isDisplayForm = !$this->isDisplayForm;
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /** @var Task */
            $task = TaskMapper::taskFromRegisterDTO($this->getForm()->getData());
            $task->setSection($this->section);
            $this->taskService->register($task);

            $this->emitUp('task:created');

            $this->resetForm();

            $this->isDisplayForm = false;
        }
    }
}
