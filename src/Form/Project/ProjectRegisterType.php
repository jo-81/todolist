<?php

namespace App\Form\Project;

use App\Form\Type\NameFieldType;
use App\DTO\Project\ProjectDTO;
use App\Form\Type\DescriptionFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', NameFieldType::class, [
                'label' => 'Nom du projet',
            ])
            ->add('description', DescriptionFieldType::class, [
                'label' => 'Description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectDTO::class,
        ]);
    }
}
