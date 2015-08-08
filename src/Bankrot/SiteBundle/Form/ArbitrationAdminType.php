<?php

namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArbitrationAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio', null, array('label' => 'ФИО'))
            ->add('cpo', null, array('label' => 'CPO'))
            ->add('body', null, array('label' => 'Описание'))
            ->add('file', null, array('label' => ' '))
            ->add('enabled','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '1' => 'Активен',
                    '0' => 'Заблокирован',
                ),
                'label' => 'Активность',
                'required'  => false,
            ))
            ->add('submit', 'submit', array('label' => 'Сохранить', 'attr' => array('class' => 'btn btn-primary')));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\Arbitration'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_arbitration';
    }
}
