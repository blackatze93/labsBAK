<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ElementoType.
 */
class ElementoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('marca')
            ->add('descripcion')
            ->add('serial')
            ->add('lugar')
            ->add('fechaIngreso', 'date', array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ))
            ->add('tipo', 'choice', array(
                'choices' => array(
                    'Computador' => 'Computador',
                    'Especializado' => 'Especializado',
                    'Otro' => 'Otro',
                ),
                'choices_as_values' => true,
            ))
            ->add('tipoPrestamo', 'choice', array(
                'choices' => array(
                    'Estudiante' => 'Estudiante',
                    'Funcionario' => 'Funcionario',
                ),
                'choices_as_values' => true,
                'label' => 'Tipo de Préstamo',
            ))
            ->add('observaciones')
            ->add('restablecer', 'reset')
        ;

        if ($options['accion'] === 'new_elemento') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_elemento') {
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
            'data_class' => 'AppBundle\Entity\Elemento',
            'accion' => 'edit_elemento',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'elemento';
    }
}
