<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EstudianteType.
 */
class EstudianteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('apellido')
            ->add('email', 'email', array(
                'required' => false,
            ))
            ->add('estado', 'choice', array(
                'choices' => array(
                    'Matriculado' => 'Matriculado',
                    'Deudor' => 'Deudor',
                ),
                'choices_as_values' => true,
            ))
            ->add('proyectocurricular', 'entity', array(
                'label' => 'Proyecto Curricular',
                'class' => 'AppBundle:ProyectoCurricular',
            ))
            ->add('restablecer', 'reset')
        ;

        if ($options['accion'] === 'new_estudiante') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_estudiante') {
            $builder
                ->add('guardar', 'submit')
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Estudiante',
            'accion' => 'edit_estudiante',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'estudiante';
    }
}
