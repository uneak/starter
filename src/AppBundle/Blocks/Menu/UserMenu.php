<?php

	namespace AppBundle\Blocks\Menu;

	use Symfony\Bundle\FrameworkBundle\Routing\Router;
    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu as PortoAdminMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;

    class UserMenu extends PortoAdminMenu {

        protected $menuHelper;
        protected $router;
//        protected $fRouteManager;
//        protected $tokenStorage;


        public function __construct(MenuHelper $menuHelper, Router $router) { //FlattenRouteManager $fRouteManager, TokenStorage $tokenStorage) {
            parent::__construct();
            $this->menuHelper = $menuHelper;
            $this->router = $router;
//            $this->fRouteManager = $fRouteManager;
//            $this->tokenStorage = $tokenStorage;


        }

        public function getRoot() {




//            $user = $this->tokenStorage->getToken()->getUser();


            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');

            $root->addChild($factory->createItem('top-separator', array(
                'attributes' => array('class' => 'divider'),
            )));

            $root->addChild($factory->createItem('profile', array(
                'label' => 'Profile',
                'icon' => 'user',
                'uri' => $this->router->generate('user_profile_show'),
            )));

            $root->addChild($factory->createItem('profile_edit', array(
                'label' => 'Edition',
                'icon' => 'edit',
                'uri' => $this->router->generate('user_profile_edit'),
            )));

            $root->addChild($factory->createItem('profile_social', array(
                'label' => 'Réseaux sociaux',
                'icon' => 'share-alt',
                'uri' => $this->router->generate('user_profile_connect'),
            )));

            $root->addChild($factory->createItem('profile_password', array(
                'label' => 'Mot de passe',
                'icon' => 'key',
                'uri' => $this->router->generate('user_change_password'),
            )));

            $root->addChild($factory->createItem('bottom-separator', array(
                'attributes' => array('class' => 'divider'),
            )));

            $root->addChild($factory->createItem('profile_logout', array(
                'label' => 'Déconnexion',
                'icon' => 'sign-out',
                'uri' => $this->router->generate('user_security_logout'),
            )));


            return $root;


        }

	}
