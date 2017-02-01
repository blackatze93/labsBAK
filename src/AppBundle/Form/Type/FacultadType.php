<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FacultadType.
 */
class FacultadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('restablecer', 'reset')
        ;

        // Dependiendo del tipo de formulario si es nueva facultad o modificcacion se agrega el boton
        if ($options['accion'] === 'new_facultad') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_facultad') {
            $builder
                // TODO: comprobar si se puede agregar este campo
//                ->add('id', 'integer', array(
//                    'attr' => array('readonly' => true)
//                ))
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
            'data_class' => 'AppBundle\Entity\Facultad',
            'accion' => 'edit_dependencia',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'facultad';
    }


}
