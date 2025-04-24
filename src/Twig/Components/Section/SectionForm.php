<?php

namespace App\Twig\Components\Section;

use App\Entity\Project;
use App\Entity\Section;
use App\Mapper\SectionMapper;
use App\DTO\Section\SectionDTO;
use App\Service\SectionService;
use App\Form\Section\SectionType;
use App\Repository\SectionRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent]
final class SectionForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    public function __construct(
        private SectionService $sectionService,
        private SectionRepository $sectionRepository,
    ) {
    }

    #[LiveProp(writable: [LiveProp::IDENTITY, 'name', 'description'])]
    public ?SectionDTO $initialFormData = null;

    #[LiveProp()]
    public Project $project;

    #[LiveProp(fieldName: 'sectionFormUpdated')]
    public ?Section $section = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        if (!isset($data['section'])) {
            return $data;
        }

        $this->initialFormData = SectionMapper::toSectionDTO($data['section']);

        return $data;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SectionType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /* @var Section */
            $section = SectionMapper::sectionFromDTO($this->getForm()->getData(), $this->section);
            $section->setProject($this->project);

            $this->sectionService->persist($section);

            $this->addFlash('success', 'Section créé !');

            return $this->redirectToRoute('project.single', ['slug' => $this->project->getSlug()]);
        }
    }
}
