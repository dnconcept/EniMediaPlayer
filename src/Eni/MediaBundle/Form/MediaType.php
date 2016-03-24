<?php

namespace Eni\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('genre', 'entity', [
                'class'    => \Eni\MediaBundle\Entity\Genre::class,
                'property' => 'name',
            ])
            ->add('createur', 'entity', [
                'class'    => \Eni\MediaBundle\Entity\Personne::class,
                'property' => 'fullName',
            ])
            ->add('fileMedia', 'file', [
                "required" => false,
            ])
            ->add('filePochette', 'file', [
                "required" => false,
            ])
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eni\MediaBundle\Entity\Media'
        ));
    }

}
