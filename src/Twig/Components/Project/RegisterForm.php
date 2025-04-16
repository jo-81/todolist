<?php

namespace App\Twig\Components\Project;

use App\Mapper\ProjectMapper;
use App\DTO\Project\ProjectRegisterDTO;
use App\Entity\Workspace;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Project\ProjectRegisterType;
use App\Service\ProjectManagementService;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class RegisterForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: [LiveProp::IDENTITY, 'name', 'description'])]
    public ?ProjectRegisterDTO $initialFormData = null;

    #[LiveProp()]
    public Workspace $workspace;

    public function __construct(private EntityManagerInterface $em)
    {}

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectRegisterType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save()
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas ajouter de projet.');
        }

        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /* @var Project */
            $project = ProjectMapper::projectFromRegisterDTO($this->getForm()->getData());
            $project->setArchived(false);
            $project->setWorkspace($this->workspace);

            $this->em->persist($project);
            $this->em->flush();

            $this->addFlash('success', 'Projet créé !');

            return $this->redirectToRoute('workspace.show', ['slug' => $this->workspace->getSlug()]);
        }
    }
}
