<?php

namespace App\Form\Task;

use App\Enum\Priority;
use App\DTO\Task\TaskRegisterDTO;
use App\Form\Type\EditorFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TaskRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la tâche',
            ])

            ->add('content', EditorFieldType::class, [
                'label' => 'Contenue',
                'required' => false,
            ])

            ->add('limitedAt', DateType::class, [
                'label' => 'Date limite',
                'required' => false,
            ])

            ->add('priority', EnumType::class, [
                'class' => Priority::class,
                'label' => 'Priorité',
                'choice_label' => function (Priority $choice) {
                    return strtolower($choice->value);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskRegisterDTO::class,
            'sanitize_html' => true,
        ]);
    }
}
