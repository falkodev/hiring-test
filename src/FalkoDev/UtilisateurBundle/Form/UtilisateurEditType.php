<?php

namespace FalkoDev\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('create')
            ->add('modify', 'submit', array('attr' => array("class" => "btn btn-primary btn-submit"),'label' => 'Modifier'))
            ->add('delete', 'submit', array('attr' => array("class" => "btn btn-danger btn-submit"),'label' => 'Supprimer'))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'falkodev_utilisateurbundle_utilisateur_edit';
    }
    
     public function getParent()
     {
        return new UtilisateurType();
     }
}
