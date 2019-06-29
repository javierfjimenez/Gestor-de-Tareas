<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titulo',
                'attr' => ['class' => 'form-control']
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenido',
                'attr' => ['class' => 'form-control']
            ))
            ->add('priority', ChoiceType::class, array(
                'label' => 'Prioridad',
                'attr' => ['class' => 'custom-select mr-sm-2 col-2 float-left padding-5'],
                'choices' => array(
                    'Alta' => 'HIGH',
                    'Media' => 'MEDIUM',
                    'Baja' => 'LOW'

                )))
            ->add('hours', TextType::class, array(
                'label' => 'Horas Presupuestadas',
                'attr' => ['class' => 'form-control']
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-primary']
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
