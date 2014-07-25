<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActeursType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('dateNaissance')
            ->add('nationalite')
            ->add('sexe', 'choice',
                array(
                    'choices' => array(0=>'femme', 1=>'homme'),
                    'expanded'=>true,
                    'data'=>0
                ))
            ->add('biography')
            ->add('fichier','file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Acteurs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_acteurs';
    }
}
