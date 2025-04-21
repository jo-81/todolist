<?php

namespace App\Twig\Components\Project;

use App\Entity\Project;
use App\Mapper\ProjectMapper;
use App\DTO\Project\ProjectDTO;
use App\Form\Project\ProjectUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class UpdateForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: [LiveProp::IDENTITY, 'name', 'description', 'archived'])]
    public ?ProjectDTO $initialFormData = null;

    #[LiveProp()]
    public Project $project;

    public function __construct(private EntityManagerInterface $em)
    {
    }

    protected function instantiateForm(): FormInterface
    {
        $this->initialFormData = ProjectMapper::toProjectDTO($this->project);

        return $this->createForm(ProjectUpdateType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function update()
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas ajouter de projet.');
        }

        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /* @var Project */
            $project = ProjectMapper::projectFromDTO($this->getForm()->getData(), $this->project);

            $this->em->persist($project);
            $this->em->flush();

            $this->addFlash('success', 'Projet modifié !');

            return $this->redirectToRoute('project.single', ['slug' => $this->project->getSlug()]);
        }
    }
}
