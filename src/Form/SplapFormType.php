<?php

namespace App\Form;

use App\Entity\SplapSavingsGoal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SplapFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Name:'])
            ->add('target', null, ['label' => 'Target:'])
            ->add('contributedAmount', null, ['label' => 'Contributed so far:'])
            ->add('duedate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Due date:'
            ])
            ->add('color', 'Symfony\Component\Form\Extension\Core\Type\ColorType', ['label' => 'Colour:']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SplapSavingsGoal::class,
        ]);
    }
}
