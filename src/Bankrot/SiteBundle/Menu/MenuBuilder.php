<?php

namespace Bankrot\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
//        $securityContext = $this->container->get('security.context');
        $currentRoute = $requestStack->getCurrentRequest()->get('_route');

        $menu
            ->setChildrenAttribute('class', 'nav navbar-nav')
            ->addChild('Торги', ['route' => 'home'])
                ->getParent()
            ->addChild('Планировщик', ['route' => 'lots_list'])
                ->setCurrent(0 === strpos($currentRoute, 'lots'))
                ->getParent()
            ->addChild('Реестры', ['route' => 'reestr_list'])//
                ->getParent()
            ->addChild('Форум', ['route' => 'forum_index'])
                ->getParent()
            ->addChild('Будьте осторожны', ['route' => 'warning_registry_list'])
                ->getParent()
            ->addChild('Контакты', ['route' => 'page','routeParameters'=>['url' => 'contacts']])
                ->getParent()
//            ->addChild('', ['route' => 'fos_user_registration_register'])
//                ->getParent()
            ->addChild('Вход / Регистрация', ['route' => 'fos_user_security_login'])
                ->getParent();

        return $menu;
    }

    public function createAuthMenu(RequestStack $requestStack, SecurityContext $securityContext)
    {
        $menu = $this->factory->createItem('root');
//        $securityContext = $this->container->get('security.context');
        $currentRoute = $requestStack->getCurrentRequest()->get('_route');
        $user = $securityContext->getToken()->getUser();


        $menu
            ->setChildrenAttribute('class', 'nav navbar-nav')
            ->addChild('Торги', ['route' => 'home'])
            ->getParent()
            ->addChild('Планировщик', ['route' => 'lots_list'])
            ->setCurrent(0 === strpos($currentRoute, 'lots'))
            ->getParent()
            ->addChild('Реестры', ['route' => 'reestr_list'])//
            ->getParent()
            ->addChild('Форум', ['route' => 'forum_index'])
            ->getParent()
            ->addChild('Будьте осторожны', ['route' => 'warning_registry_list'])
            ->getParent()
            ->addChild('Контакты', ['route' => 'page','routeParameters'=>['url' => 'contacts']])
            ->getParent()
            ->addChild($user->getLastName().' '.mb_substr($user->getFirstName(), 0, 1, 'utf-8'), ['route' => 'fos_user_profile_show'])
            ->getParent();
//            ->addChild('Выйти', ['route' => 'fos_user_security_logout'])
//            ->getParent();

        return $menu;
    }


    public function createLotsMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $currentRoute = $requestStack->getCurrentRequest()->get('_route');

        $menu
            ->setChildrenAttribute('class', 'nav navbar-nav')
            ->addChild('Активные', ['route' => 'lots_list'])
                ->setCurrent('lots_list' === $currentRoute)
                ->getParent()
            ->addChild('Неактивные', ['route' => 'lots_list_inactive'])
                ->setCurrent('lots_list_inactive' === $currentRoute)
                ->getParent()
            ->addChild('Задачи', ['route' => 'task_lists'])
                ->setCurrent('task_lists' === $currentRoute)
                ->getParent()
            ->addChild('Архив', ['route' => 'lots_list_archive'])
                ->setCurrent('lots_list_archive' === $currentRoute)
                ->getParent()
            ;

        return $menu;
    }
}
