<?php

namespace AppBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaginaType extends AbstractType
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
            ->add('contenido', CKEditorType::class, array(
                'config_name' => 'full_config'
            ))
            ->add('guardar', SubmitType::class)
            ->add('restablecer', ResetType::class)
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
            'data_class' => 'AppBundle\Entity\Pagina',
        ));
    }

    /**
     * Metodo que configura el prefijo que tendran los campos del form.
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'pagina';
    }
}
