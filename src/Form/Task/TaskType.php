<?php

namespace App\Form\Task;

use App\Enum\Status;
use App\Enum\Priority;
use App\DTO\Task\TaskDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la tâche',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenue',
                'required' => false,
            ])
            ->add('limitedAt', DateType::class, [
                'label' => 'Date limite',
            ])
            ->add('status', EnumType::class, [
                'class' => Status::class,
            ])
            ->add('priority', EnumType::class, [
                'class' => Priority::class,
                'label' => 'Priorité',
                'choice_label' => function (Priority $choice) {
                    return strtolower($choice->value);
                },
            ])
            ->add('archived', CheckboxType::class, [
                'required' => false,
                'label' => 'Archivée',
            ])
            ->add('completed', CheckboxType::class, [
                'required' => false,
                'label' => 'Terminée',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskDTO::class,
        ]);
    }
}
