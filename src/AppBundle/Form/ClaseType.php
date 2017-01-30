<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClaseType.
 */
class ClaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lugar')
            ->add('fecha_inicio', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
            ))
            ->add('fecha_fin', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
            ))
            ->add('estado', 'choice', array(
                'choices' => array(
                    'Activa' => 'Activa',
                    'Cancelada' => 'Cancelada',
                    'Practica Libre' => 'Practica Libre',
                    'Mantenimiento' => 'Mantenimiento',
                    'Otro' => 'Otro',
                ),
                'choices_as_values' => true,
            ))
            ->add('materia')
            ->add('grupo')
            ->add('observaciones')
            ->add('restablecer', 'reset')
        ;

        // Dependiendo del tipo de formulario si es nuevo lugar o modificcacion se agrega el boton
        if ($options['accion'] === 'new_clase') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_clase') {
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
            'data_class' => 'AppBundle\Entity\Clase',
            'accion' => 'edit_clase',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clase';
    }
}
