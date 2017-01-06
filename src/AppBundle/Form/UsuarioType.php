<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id', 'number')
            ->add('nombre')
            ->add('apellido')
            ->add('email', 'email')
            ->add('passwordEnClaro', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar Contraseña'),
                'first_name' => 'pass1',
                'second_name' => 'pass2',
                'required' => false,
            ))
            ->add('cargo', 'choice', array(
                'choices' => array(
                    'ROLE_USUARIO' => 'Usuario',
                    'ROLE_DOCENTE' => 'Docente',
                    'ROLE_ADMINISTRATIVO' => 'Administrativo',
                )
            ))
            ->add('funciones')
            ->add('dependencia')
            ->add('estaActivo', 'checkbox', array('required' => false))
            ->add('restablecer', 'reset')
        ;

        if ($options['accion'] === 'crear_usuario') {
            $builder
                ->add('registrar', 'submit')
            ;
        } else if ($options['accion'] === 'modificar_perfil') {
            $builder
                ->add('guardar', 'submit')
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver ->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'accion' => 'modificar_perfil',
        ));
    }

    public function getBlockPrefix() {
        return 'usuario';
    }
}