<?php

namespace Bankrot\SiteBundle\Form\Type;

use Bankrot\SiteBundle\Entity\DropRule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Bankrot\SiteBundle\Form\Type\DropRuleType;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Наименование', 'attr' => ['placeholder' => 'Введите наименование']])
            ->add('category', 'entity', ['label' => 'Категория',  'class'=>'Bankrot\SiteBundle\Entity\Category',  'property'=>'name'])
            ->add('url', 'text', ['label' => 'Ссылка на лот', 'attr' => ['placeholder' => 'Введите ссылку на лот'],'required' => false,])
            ->add('phone', null, ['label' => 'Телефон', 'attr' => ['placeholder' => 'Введите телефон'],'required' => false,])
            ->add('price', null, ['label' => 'Рыночная стоимость', 'attr' => ['placeholder' => 'Введите рыночную стоимость'],'required' => false,])
            ->add('address', null, ['label' => 'Адрес', 'attr' => ['placeholder' => 'Введите адрес'],'required' => false,])
            ->add('description', null, ['label' => 'Описание', 'attr' => ['rows' => 5, 'placeholder' => 'Введите описание'],'required' => false,])
            ->add('initialPrice', null, ['label' => 'Начальная стоимость', 'attr' => ['placeholder' => 'Введите начальную стоимость'],'required' => false,])
            ->add('cutOffPrice', null, ['attr' => ['placeholder' => 'Введите значение в рублях'],'required' => false,])
            ->add('cutOffPricePercent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от начальной стоимости'],'required' => false,])
            ->add('depositPrice', null, ['attr' => ['placeholder' => 'Введите значение в рублях'],'required' => false,])
            ->add('depositPricePercent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от начальной стоимости'],'required' => false,])
            ->add('depositPricePercentCurrent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от стоимости текущего периода'],'required' => false,])
            ->add('lotStatus', null, ['label' => 'Статус лота','required' => false,])
//            ->add('', null, ['label' => 'Статус лота', 'empty_value' => '-'])
            ->add('lotStatus', 'entity', ['label' => 'Статус лота',  'class'=>'Bankrot\SiteBundle\Entity\LotStatus',  'property'=>'name'])


            ->add('livePeriod', 'text', ['mapped' => false, 'label' => 'Начало приема заявок–окончание приема заявок', 'attr' => [
                'data-inputmask' => '99.99.9999 - 99.99.9999', 
                'placeholder' => 'Введите ачало приема заявок – окончание приема заявок',
            ],'required' => false,])


//            ->add('newDropRulePeriod', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
//                new Assert\Range(['min' => 0]),
//            ],'required' => false,])
//            ->add('newDropRulePeriodWork', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
//                new Assert\Range(['min' => 0]),
//            ],'required' => false,])
//            ->add('newDropRuleOrder', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
//                new Assert\Range(['min' => 0]),
//            ],'required' => false,])
//            ->add('newDropRuleOrderCurrent', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
//                new Assert\Range(['min' => 0, 'max' => 100]),
//            ],'required' => false,])
//            ->add('newDropRuleLivePeriod', 'text', ['mapped' => false, 'label' => 'Период действия', 'attr' => [
//                'data-inputmask' => '99.99.9999 - 99.99.9999',
//                'placeholder' => 'Введите период действия',
//            ],'required' => false,])




            ->add('costPurchase', 'text', ['label' => 'Стоимость покупки','required' => false])
            ->add('costAcquisition', 'text', ['label' => 'Расходы на приобретение','required' => false])
            ->add('periodPayback', 'text', ['label' => 'Срок окупаемости','required' => false])
            ->add('ViewCapitalization', null, ['label' => 'Вид капитализации','required' => false])
            ->add('minCostCapitalization', 'text', ['label' => 'Мин. стоимость капитализации','required' => false])
            ->add('maxCostCapitalization', 'text', ['label' => 'Макс. стоимость капитализации','required' => false])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bankrot\SiteBundle\Entity\Lot',
        ]);
    }

    public function getName()
    {
        return 'lot';
    }
}
