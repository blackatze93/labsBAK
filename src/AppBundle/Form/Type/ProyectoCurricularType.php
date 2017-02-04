<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProyectoCurricularType.
 */
class ProyectoCurricularType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
            ->add('facultad', 'choice', array(
                'choices' => array(
                    'Facultad Tecnológica' => 'Tecnologica',
                    'Facultad del Medio Ambiente' => 'Medio Ambiente',
                    'Facultad de Ingeniería' => 'Ingenieria',
                    'Facultad de Ciencias y Educación' => 'Ciencias y Educacion',
                    'Facultad de Artes - ASAB' => 'ASAB',
                ),
                'choices_as_values' => true,
            ))
            ->add('restablecer', 'reset')
        ;

        if ($options['accion'] === 'new_proyectocurricular') {
            $builder
                ->add('crear', 'submit')
            ;
        } elseif ($options['accion'] === 'edit_proyectocurricular') {
            $builder
                ->add('guardar', 'submit');
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ProyectoCurricular',
            'accion' => 'edit_proyectocurricular',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'proyectocurricular';
    }
}
