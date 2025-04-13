<?php

namespace App\Form\Workspace;

use App\DTO\Workspace\WorkspaceDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class WorkspaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du workspace',
                'help' => 'Nombre de caractères : entre 3 et 20.',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'help' => 'Champ optionnel.',
                'attr' => [
                    'rows' => 5,
                    'data-character-counter-target' => 'input',
                    'maxlength' => 400,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkspaceDTO::class,
        ]);
    }
}
