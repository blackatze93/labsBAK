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
     * Metodo para crear el formulario de la entidad Usuario con los campos requeridos.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
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
            ->add('estado', ChoiceType::class, array(
                'choices' => array(
                    'Paz y Salvo' => 'Paz y Salvo',
                    'En Mora' => 'En Mora',
                ),
                'choices_as_values' => true,
            ))
            ->add('dependencia')
            ->add('proyectoCurricular')
            ->add('restablecer', ResetType::class)
        ;

        // Dependiendo del tipo de formulario si es nuevo usuario o modificcacion se agrega el boton
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
     * Metodo que configura las opciones por defecto que tendra el formulario.
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
     * Metodo que configura el prefijo que tendran los campos del formulario.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'usuario';
    }
}
