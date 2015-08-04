<?php

namespace Bankrot\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('username', null, ['label' => 'Логин:']);
        $builder->add('email', null, ['label' => 'Email:']);
        $builder->add('lastName', null, ['label' => 'Фамилия:']);
        $builder->add('firstName', null, ['label' => 'Имя:']);
        $builder->add('surName', null, ['label' => 'Отчество:']);
        $builder->add('phone', null, ['label' => 'Телефон:']);
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'пароли не совпадают',
            'first_options'  => array('label' => 'Пароль:'),
            'second_options' => array('label' => 'Повторите пароль:'),
        ));
//        $builder->add('register', 'submit', ['label' => 'Зарегистрироваться','attr' => ['class' => 'btn-primary']]);
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'bankrot_site_user_registration';
    }
}