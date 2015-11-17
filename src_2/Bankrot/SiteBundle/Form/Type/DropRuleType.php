<?php

namespace Bankrot\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DropRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newDropRulePeriod', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ],'required' => false,])
            ->add('newDropRulePeriodWork', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ],'required' => false,])
            ->add('newDropRuleOrder', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ],'required' => false,])
            ->add('newDropRuleOrderCurrent', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
                new Assert\Range(['min' => 0, 'max' => 100]),
            ],'required' => false,])
            ->add('newDropRuleLivePeriod', 'text', ['mapped' => false, 'label' => 'Период действия', 'attr' => [
                'data-inputmask' => '99.99.9999 - 99.99.9999',
                'placeholder' => 'Введите период действия',
            ],'required' => false,]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bankrot\SiteBundle\Entity\DropRule',
        ]);
    }

    public function getName()
    {
        return 'droprule';
    }
}