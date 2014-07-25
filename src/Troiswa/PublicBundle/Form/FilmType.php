<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilmType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('spectateur', 'hidden')
            ->add('synopsis')
            ->add('dateCreation')
            ->add('fichier','file')
            ->add('categorie', 'entity',
            array('class'=>'TroiswaPublicBundle:Categorie', 'property'=>'titre' )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_film';
    }
}
