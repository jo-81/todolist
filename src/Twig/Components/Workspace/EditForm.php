<?php

namespace App\Twig\Components\Workspace;

use App\Entity\Workspace;
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
final class EditForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: ['name', 'description'], hydrateWith: 'hydrateWorkspace', dehydrateWith: 'dehydrateWorkspace')]
    public WorkspaceDTO $initialFormData;

    #[LiveProp(fieldName: 'workspace_update')]
    public Workspace $workspace;

    public function __construct(
        private WorkspaceManagementService $workspaceManagementService,
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        $this->initialFormData = WorkspaceMapper::toWorkspaceDTO($this->workspace);

        return $this->createForm(WorkspaceType::class, $this->initialFormData);
    }

    public function dehydrateWorkspace(WorkspaceDTO $workspaceDTO)
    {
        return [
            'name' => $workspaceDTO->getName(),
            'description' => $workspaceDTO->getDescription(),
        ];
    }

    public function hydrateWorkspace(array $data): WorkspaceDTO
    {
        return (new WorkspaceDTO())->setName($data['name'])->setDescription($data['description']);
    }

    #[LiveAction]
    public function update()
    {
        if (!$this->isGranted('WORKSPACE_EDIT', $this->workspace)) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas modifier ce workspace.');
        }

        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /* @var Workspace */
            $workspace = WorkspaceMapper::workspaceFromDTO($this->getForm()->getData(), $this->workspace);
            $this->workspaceManagementService->persist($workspace);
            $this->addFlash('success', 'Workspace modifié !');

            return $this->redirectToRoute('workspace.show', ['slug' => $workspace->getSlug()]);
        }
    }
}
