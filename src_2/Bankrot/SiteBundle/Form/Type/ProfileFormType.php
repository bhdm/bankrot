<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bankrot\SiteBundle\Form\Type;;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        parent::buildForm($builder, $options);

        $builder->add('username', null, ['label' => 'Логин:']);
        $builder->add('email', null, ['label' => 'Email:']);
        $builder->add('lastName', null, ['label' => 'Фамилия:']);
        $builder->add('firstName', null, ['label' => 'Имя:']);
        $builder->add('surName', null, ['label' => 'Отчество:']);
        $builder->add('phone', null, ['label' => 'Телефон:']);

        $builder->add('current_password', 'password', array(
            'label' => 'Текущий пароль',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'bankrot_site_user_profile_edit';
    }
}