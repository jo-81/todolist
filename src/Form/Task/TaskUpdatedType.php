<?php

namespace App\Form\Task;

use App\Enum\Status;
use App\DTO\Task\TaskUpdatedDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TaskUpdatedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', EnumType::class, [
                'class' => Status::class,
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

    public function getParent(): ?string
    {
        return TaskRegisterType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskUpdatedDTO::class,
            'sanitize_html' => true,
        ]);
    }
}
