<?php

namespace Eni\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', 'text')
            ->add('nom', 'text')
            ->add('email', 'email')
            ->add('password', 'password')
            ->add('latitude', 'number')
            ->add('longitude', 'number');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eni\MediaBundle\Entity\Personne'
        ));
    }
}
