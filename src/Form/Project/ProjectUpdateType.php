<?php

namespace App\Form\Project;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProjectUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('archived', ChoiceType::class, [
                'label' => 'Archivé ?',
                'expanded' => true,
                'attr' => [
                    'class' => 'd-flex gap-3',
                ],
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
        ;
    }

    public function getParent(): string
    {
        return ProjectRegisterType::class;
    }
}
