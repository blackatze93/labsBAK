<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use JavierEguiluz\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TrasladoElementoType.
 */
class TrasladoElementoType extends AbstractType
{
    /**
     * Metodo para crear el form de la entidad TrasladoElemento con los campos requeridos.
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
            'data_class' => 'AppBundle\Entity\TrasladoElemento',
        ));
    }

    /**
     * Metodo que configura el prefijo que tendran los campos del form.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'traslado_elemento';
    }
}
