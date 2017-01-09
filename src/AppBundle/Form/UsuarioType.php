<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UsuarioType
 * @package AppBundle\Form
 */
class UsuarioType extends AbstractType {
    /**
     * Metodo para crear el formulario de la entidad Usuario con los campos requeridos
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                    'Administrador' => 'ROLE_ADMIN',
                    'Docente' => 'ROLE_DOCENTE',
                    'Administrativo' => 'ROLE_ADMINISTRATIVO',
                ),
                'choices_as_values' => true,
            ))
            ->add('funciones')
            ->add('dependencia')
            ->add('estaActivo', 'checkbox', array('required' => false))
            ->add('restablecer', 'reset')
        ;

        // Dependiendo del tipo de formulario si es nuevo usuario o modificcacion se agrega el boton
        if ($options['accion'] === 'new_usuario') {
            $builder
                ->add('crear', 'submit')
            ;
        } else if ($options['accion'] === 'modificar_perfil') {
            $builder
                ->add('guardar', 'submit')
            ;
        }

    }

    /**
     * Metodo que configura las opciones por defecto que tendra el formulario
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver ->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'accion' => 'modificar_perfil',
        ));
    }

    /**
     * Metodo que configura el prefijo que tendran los campos del formulario
     *
     * @return string
     */
    public function getBlockPrefix() {
        return 'usuario';
    }
}