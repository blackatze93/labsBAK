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
            ->add('email')
            ->add('password')
            ->add('cargo')
            ->add('funciones')
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