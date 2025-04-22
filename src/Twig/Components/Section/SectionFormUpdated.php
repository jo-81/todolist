<?php

namespace App\Twig\Components\Section;

use App\Entity\Section;
use App\Mapper\SectionMapper;
use App\DTO\Section\SectionDTO;
use App\Service\SectionService;
use App\Form\Section\SectionType;
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
final class SectionFormUpdated extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    public function __construct(
        private SectionService $sectionService,
    ) {
    }

    #[LiveProp(writable: [LiveProp::IDENTITY, 'name', 'description'])]
    public SectionDTO $initialFormData;

    #[LiveProp(fieldName: 'sectionFormUpdated')]
    public Section $section;

    #[PreMount]
    public function preMount(array $data): array
    {
        if (! isset($data['section'])) {
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
    public function updated()
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            /* @var Section */
            $section = SectionMapper::sectionFromDTO($this->getForm()->getData(), $this->section);

            $this->sectionService->persist($section);

            $this->emitUp("section:updated");
        }
    }
}
