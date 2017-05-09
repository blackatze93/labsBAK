<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use JavierEguiluz\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BajaElementoType.
 */
class BajaElementoType extends AbstractType
{
    /**
     * Metodo para crear el form de la entidad BajaElemento con los campos requeridos.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('elemento', EasyAdminAutocompleteType::class, array(
                'class' => 'AppBundle\Entity\Elemento',
            ))
            ->add('observacion')
            ->add('motivoBaja', EntityType::class, array(
                'class' => 'AppBundle\Entity\MotivoBaja',
                'attr' => array(
                    'data-widget' => 'select2',
                ),
            ))
        ;
    }

    /**
     * Metodo que configura las opciones por defecto que tendra el form.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BajaElemento',
        ));
    }

    /**
     * Metodo que configura el prefijo que tendran los campos del form.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'baja_elemento';
    }
}
