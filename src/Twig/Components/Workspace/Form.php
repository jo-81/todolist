<?php

namespace App\Twig\Components\Workspace;

use App\DTO\Workspace\WorkspaceDTO;
use App\Form\Workspace\WorkspaceType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class Form extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true)]
    public ?WorkspaceDTO $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(WorkspaceType::class, $this->initialFormData);
    }
}
