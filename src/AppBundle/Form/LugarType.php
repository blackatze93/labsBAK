<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LugarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('capacidad')
            ->add('visible', 'checkbox', array('required' => false))
            ->add('descripcion')
            ->add('restablecer', 'reset')
        ;

        // Dependiendo del tipo de formulario si es nuevo lugar o modificcacion se agrega el boton
        if ($options['accion'] === 'new_lugar') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_lugar') {
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
            'data_class' => 'AppBundle\Entity\Lugar',
            'accion' => 'edit_lugar',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lugar';
    }
}
