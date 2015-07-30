<?php

namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReestrType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio')
            ->add('number')
            ->add('registerDate')
            ->add('openDate')
            ->add('cpo')
            ->add('rating')
            ->add('debtorCategory')
            ->add('debtorInn')
            ->add('debtorOgrn')
            ->add('debtorRegion')
            ->add('debtorAdrs')
            ->add('debtorTitle')
            ->add('debtorFullTitle')
            ->add('organizatorTitle')
            ->add('organizatorRegion')
            ->add('organizatorAdrs')
            ->add('organizatorInn')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\Reestr'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_reestr';
    }
}
