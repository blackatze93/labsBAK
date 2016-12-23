<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('apellido')
            ->add('email', 'email')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar Contraseña'),
                'first_name' => 'pass1',
                'second_name' => 'pass2',
            ))
            ->add('cargo')
            ->add('funciones')
            ->add('estaActivo', 'checkbox', array('required' => false))
            ->add('dependencia')
            ->add('registrar', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver ->setDefaults(array(
           'data_class' => 'AppBundle\Entity\Usuario',
        ));
    }

    public function getBlockPrefix() {
        return 'uauario';
    }
}