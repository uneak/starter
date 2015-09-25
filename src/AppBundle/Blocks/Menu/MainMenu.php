<?php

    namespace AppBundle\Blocks\Menu;

	use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu as PortoAdminMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;
    use Uneak\RoutesManagerBundle\Security\Authorization\Voter\RouteVoter;

    class MainMenu extends PortoAdminMenu {

        protected $menuHelper;
        protected $fRouteManager;
        protected $authorization;

		public function __construct(MenuHelper $menuHelper, FlattenRouteManager $fRouteManager, AuthorizationChecker $authorization) {
			parent::__construct();
            $this->menuHelper = $menuHelper;
            $this->fRouteManager = $fRouteManager;
            $this->authorization = $authorization;
		}

        public function getRoot() {

            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');

            $fRoutes = $this->fRouteManager->getFlattenRoutes();
            foreach ($fRoutes as $fRoute) {

                if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $fRoute) === true) {
                    $menu = $this->menuHelper->createItem($fRoute);
                    foreach ($fRoute->getChildren() as $fChildRoute) {
                        if (!$fChildRoute instanceof FlattenEntityRoute) {
                            $childMenu = $this->menuHelper->createItem($fChildRoute);
                            $menu->addChild($childMenu);
                        }
                    }
                    $root->addChild($menu);
                }
            }

//
//            $choices = $factory->createItem('test', array(
//                'label' => 'choix',
//                'icon' => 'user'
//            ));
//            $root->addChild($choices);
//            $choices2 = $factory->createItem('test2', array(
//                'label' => 'choiXx',
//                'icon' => 'user'
//            ));
//            $root->addChild($choices2);
//
//            if (null !== $itemNews = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('user/index'))) {
//                $itemNews->setExtra("badge", "15");
//                $itemNews->setExtra("badge_context", "danger");
//                $choices->addChild($itemNews);
//            }
//
//            if (null !== $itemNews2 = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('admin'))) {
//                $itemNews2->setExtra("badge", "15");
//                $choices->addChild($itemNews2);
//            }

            return $root;
        }


	}
