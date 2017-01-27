<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventoType.
 */
class EventoType extends AbstractType
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
            ->add('tipo', 'choice', array(
                'choices' => array(
                    'Clase' => 'Clase',
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
        if ($options['accion'] === 'new_evento') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_evento') {
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
            'data_class' => 'AppBundle\Entity\Evento',
            'accion' => 'edit_evento',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evento';
    }
}
