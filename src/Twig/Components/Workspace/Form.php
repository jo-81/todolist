<?php

namespace App\Twig\Components\Workspace;

use App\Mapper\WorkspaceMapper;
use App\DTO\Workspace\WorkspaceDTO;
use App\Form\Workspace\WorkspaceType;
use Symfony\Component\Form\FormInterface;
use App\Service\WorkspaceManagementService;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class Form extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: ['name', 'description'])]
    public ?WorkspaceDTO $initialFormData = null;

    public function __construct(
        private WorkspaceManagementService $workspaceManagementService,
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(WorkspaceType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            $workspace = WorkspaceMapper::workspaceFromDTO($this->getForm()->getData());
            $workspace->setOwner($this->getUser());
            $this->workspaceManagementService->persist($workspace);
            $this->addFlash('success', 'Workspace créé !');

            return $this->redirectToRoute('workspace.index');
        }
    }
}
