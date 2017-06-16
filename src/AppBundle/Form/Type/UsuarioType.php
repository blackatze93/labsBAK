<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UsuarioType.
 */
class UsuarioType extends AbstractType
{
    /**
     * Metodo para crear el form de la entidad Usuario con los campos requeridos.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDocumento', ChoiceType::class, array(
                'choices' => array(
                    'C.C.' => 'Cédula de Ciudadanía',
                    'T.I.' => 'Tarjeta de Identidad',
                    'C.E.' => 'Cédula de Extranjería',
                ),
            ))
            ->add('documento')
            ->add('codigo')
            ->add('nombre')
            ->add('apellido')
            ->add('email', EmailType::class)
            ->add('passwordEnClaro', RepeatedType::class, array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options' => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar Contraseña'),
                'first_name' => 'pass1',
                'second_name' => 'pass2',
                'required' => false,
            ))
            ->add('rol', ChoiceType::class, array(
                'choices' => array(
                    'ROLE_FUNCIONARIO' => 'ROLE_FUNCIONARIO',
                    'ROLE_DOCENTE' => 'ROLE_DOCENTE',
                    'ROLE_ESTUDIANTE' => 'ROLE_ESTUDIANTE',
                ),
                'choices_as_values' => true,
            ))
            ->add('cargo')
            ->add('dependencia', null, array(
                'empty_value' => 'Ninguna',
            ))
            ->add('proyectoCurricular', null, array(
                'empty_value' => 'Ninguno',
            ))
            ->add('restablecer', ResetType::class)
        ;

        // Dependiendo del tipo de form si es nuevo usuario o modificcacion se agrega el boton
        if ($options['accion'] === 'registro') {
            $builder
                ->add('crear', SubmitType::class)
            ;
        } elseif ($options['accion'] === 'modificar_perfil') {
            $builder
                ->add('guardar', SubmitType::class)
            ;
        }
    }

    /**
     * Metodo que configura las opciones por defecto que tendra el form.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'accion' => 'modificar_perfil',
        ));
    }

    /**
     * Metodo que configura el prefijo que tendran los campos del form.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'usuario';
    }
}
