<?php

namespace App\Form\Section;

use App\DTO\Section\SectionDTO;
use App\Form\Type\NameFieldType;
use App\Form\Type\DescriptionFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', NameFieldType::class, [
                'label' => 'Nom de la section',
            ])
            ->add('description', DescriptionFieldType::class, [
                'label' => 'Description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SectionDTO::class,
        ]);
    }
}
