<?php

namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lotTitle', null, array('label' => 'Название лота'))
            ->add('lotLink', null, array('label' => 'Ссылка'))
            ->add('body', null, array('label' => 'Описание'))
            ->add('submit', 'submit', array('label' => 'Отправить', 'attr' => array('class' => 'btn btn-primary')));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\Registry'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_registry';
    }
}
