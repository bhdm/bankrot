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

            ->add('category', 'choice', array(
                'label' => 'Категория',
                'choices'  => array(
                    0 => 'Должники',
                    1 => 'CPO',
                    2 => 'Арбитражные управдяющие',
                    3 => 'Организаторы торгов',
                    4 => 'Торговые площадки',
                    5 => 'Дискалифицированные лица'
                ),
                'required' => true,
            ))
            ->add('aShotTitle' , null , array('label' => 'Краткое наименование', 'attr' => array('class' => 'a')))
            ->add('aFullTitle' , null , array('label' => 'Полное наименование', 'attr' => array('class' => 'a')))
            ->add('aAdrs'       , null , array('label' => 'Адрес', 'attr' => array('class' => 'a')))
            ->add('aRegion'     , null , array('label' => 'Регион', 'attr' => array('class' => 'a')))
            ->add('aSubCategory' , null , array('label' => 'Категория должника', 'attr' => array('class' => 'a')))
            ->add('aInn'        , null , array('label' => 'ИНН', 'attr' => array('class' => 'a')))
            ->add('aOgrn'       , null , array('label' => 'ОГРН', 'attr' => array('class' => 'a')))
            ->add('aForma'      , null , array('label' => 'Организационно-правовая форма', 'attr' => array('class' => 'a')))

            ->add('bTitle'          , null , array('label' => 'Наименование', 'attr' => array('class' => 'b')))
            ->add('bNumber'         , null , array('label' => 'Регистрационный номер', 'attr' => array('class' => 'b')))
            ->add('bRegisterDate'   , null , array('label' => 'Дата регистрации', 'attr' => array('class' => 'b')))
            ->add('bInn'            , null , array('label' => 'ИНН', 'attr' => array('class' => 'b')))
            ->add('bAdrsCpo'        , null , array('label' => 'Юридический адрес по данным СРО', 'attr' => array('class' => 'b')))
            ->add('bAdrsReestr'     , null , array('label' => 'Юридический адрес по данным Росреестра', 'attr' => array('class' => 'b')))
            ->add('bAdrsMail'       , null , array('label' => 'Почтовый адрес', 'attr' => array('class' => 'b')))
            ->add('bPhone'          , null , array('label' => 'Телефон/Факс', 'attr' => array('class' => 'b')))
            ->add('bEmail'          , null , array('label' => 'Адрес электронной почты', 'attr' => array('class' => 'b')))
            ->add('bSite'           , null , array('label' => 'Адрес в интернете', 'attr' => array('class' => 'b')))
            ->add('bSizeFondCpo'    , null , array('label' => 'Размер компенсационного фонда (по данным СРО)', 'attr' => array('class' => 'b')))
            ->add('bDateFondCpo'    , null , array('label' => 'Дата изменения размера комп. фонда (по данным СРО)', 'attr' => array('class' => 'b')))
            ->add('bSizeFondReestr' , null , array('label' => 'Размер компенсционного фонда (по данным Росреестра)', 'attr' => array('class' => 'b')))
            ->add('bManager'        , null , array('label' => 'Руководитель', 'attr' => array('class' => 'b')))
            ->add('bContact'        , null , array('label' => 'Контактное лицо', 'attr' => array('class' => 'b')))
            ->add('bCountManager'   , null , array('label' => 'Количество управляющих', 'attr' => array('class' => 'b')))

            ->add('cLastName' , null , array('label' => 'Фамилия', 'attr' => array('class' => 'c')))
            ->add('cFirstName' , null , array('label' => 'Имя', 'attr' => array('class' => 'c')))
            ->add('cSurName' , null , array('label' => 'Отчество', 'attr' => array('class' => 'c')))
            ->add('cInn' , null , array('label' => 'ИНН', 'attr' => array('class' => 'c')))
            ->add('cNumber' , null , array('label' => 'Рег. номер', 'attr' => array('class' => 'c')))
            ->add('cCpo' , null , array('label' => 'СРО', 'attr' => array('class' => 'c')))
            ->add('cDate' , null , array('label' => 'Дата вступления', 'attr' => array('class' => 'c')))

            ->add('dShotTitle' , null , array('label' => 'Краткое наименование', 'attr' => array('class' => 'd')))
            ->add('dFullTitle' , null , array('label' => 'Полное наименование', 'attr' => array('class' => 'd')))
            ->add('dAdrs' , null , array('label' => 'Адрес', 'attr' => array('class' => 'd')))
            ->add('dPhone' , null , array('label' => 'Телефон', 'attr' => array('class' => 'd')))
            ->add('dRegion' , null , array('label' => 'Регион', 'attr' => array('class' => 'd')))
            ->add('dInn' , null , array('label' => 'ИНН', 'attr' => array('class' => 'd')))
            ->add('dKpp' , null , array('label' => 'КПП', 'attr' => array('class' => 'd')))
            ->add('dOgrn' , null , array('label' => 'ОГРН', 'attr' => array('class' => 'd')))
            ->add('dOkpo' , null , array('label' => 'ОКПО', 'attr' => array('class' => 'd')))
            ->add('dForma' , null , array('label' => 'Организационно-правовая форма', 'attr' => array('class' => 'd')))

            ->add('eTitle' , null , array('label' => 'Наименование', 'attr' => array('class' => 'e')))
            ->add('eFullTitle' , null , array('label' => 'Наименование / ФИО', 'attr' => array('class' => 'e')))
            ->add('eSite' , null , array('label' => 'Сайт', 'attr' => array('class' => 'e')))
            ->add('eAdrs' , null , array('label' => 'Адреc', 'attr' => array('class' => 'e')))
            ->add('eInn' , null , array('label' => 'ИНН', 'attr' => array('class' => 'e')))
            ->add('eOgrn' , null , array('label' => 'ОГРН / ОГРНИП', 'attr' => array('class' => 'e')))

            ->add('fFio' , null , array('label' => 'ФИО', 'attr' => array('class' => 'f')))
            ->add('fBirthday' , null , array('label' => 'Дата рождения', 'attr' => array('class' => 'f')))
            ->add('fCountry' , null , array('label' => 'Место рождения (страна/республика)', 'attr' => array('class' => 'f')))
            ->add('fRegion' , null , array('label' => 'Место рождения (край, область, район, город, насел. пункт)', 'attr' => array('class' => 'f')))
            ->add('fworkPlace' , null , array('label' => 'Место работы (наименование организации)', 'attr' => array('class' => 'f')))
            ->add('fPost' , null , array('label' => 'Должность', 'attr' => array('class' => 'f')))
            ->add('fSupreme' , null , array('label' => 'Орган, составивший протокол (ведомственная принадлежность)', 'attr' => array('class' => 'f')))
            ->add('fTitleOrgan' , null , array('label' => 'Орган, составивший протокол (наименование)', 'attr' => array('class' => 'f')))
            ->add('fOffense' , null , array('label' => 'Характер правонарушения', 'attr' => array('class' => 'f')))
            ->add('fQualification' , null , array('label' => 'Квалификация', 'attr' => array('class' => 'f')))
            ->add('fOffenseDate' , null , array('label' => 'Дата выявления правонарушения', 'attr' => array('class' => 'f')))
            ->add('fIssuedResolutionRegion' , null , array('label' => 'Кем вынесено постановление (субъект РФ)', 'attr' => array('class' => 'f')))
            ->add('fIssuedResolutionTitle' , null , array('label' => 'Кем вынесено постановление (наименование суда)', 'attr' => array('class' => 'f')))
            ->add('fIssuedDate' , null , array('label' => 'Дата вынесения', 'attr' => array('class' => 'f')))
            ->add('fDisqualification' , null , array('label' => 'Срок дисквалификации', 'attr' => array('class' => 'f')))
            ->add('fDateStart' , null , array('label' => 'Дата начала', 'attr' => array('class' => 'f')))
            ->add('fDateEnd' , null , array('label' => 'Дата истечения', 'attr' => array('class' => 'f')))
            ->add('fNumber' , null , array('label' => 'Номер дела', 'attr' => array('class' => 'f')))

            ->add('submit', 'submit', array('label' => 'Отправить', 'attr' => array('class' => 'btn btn-primary')));
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
