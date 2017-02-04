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
                    'Facultad Tecnológica' => 'Facultad Tecnológica',
                    'Facultad del Medio Ambiente' => 'Facultad del Medio Ambiente',
                    'Facultad de Ingeniería' => 'Facultad de Ingeniería',
                    'Facultad de Ciencias y Educación' => 'Facultad de Ciencias y Educación',
                    'Facultad de Artes - ASAB' => 'Facultad de Artes - ASAB',
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
