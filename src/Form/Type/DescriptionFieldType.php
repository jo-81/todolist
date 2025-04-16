<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DescriptionFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['required'] = false;
        $view->vars['help'] = 'Champ optionnel.';
        $view->vars['attr']['rows'] = 5;
        $view->vars['attr']['class'] = 'form-control';
        $view->vars['attr']['data-character-counter-target'] = 'input';
        $view->vars['attr']['maxlength'] = 400;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
