<?php

namespace FalkoDev\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite','choice', array('choices' => array('M' => 'M', 'Mme' => 'Mme', 'Melle' => 'Melle'), 
                                             'attr' => array("class" => "form-control"),
                                             'label' => 'Civilité'))
            ->add('nom', 'text', array('attr' => array("class" => "form-control")))
            ->add('prenom', 'text', array('attr' => array("class" => "form-control"), 'label' => 'Prénom'))
            ->add('mail', 'text', array('attr' => array("class" => "form-control")))
            ->add('adresse', 'text', array('attr' => array("class" => "form-control")))
            ->add('codePostal', 'integer', array('attr' => array("class" => "form-control")))
            ->add('ville', 'text', array('attr' => array("class" => "form-control")))
            ->add('create', 'submit', array('attr' => array("class" => "btn btn-primary btn-submit"),'label' => 'Créer'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FalkoDev\UtilisateurBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'falkodev_utilisateurbundle_utilisateur';
    }
}
