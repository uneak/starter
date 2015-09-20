<?php

    namespace AppBundle\Blocks\Breadcrumb;

	use Uneak\PortoAdminBundle\Blocks\Menu\FlattenRouteMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenAdminRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;
    use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;

    class Breadcrumb extends FlattenRouteMenu {


        public function __construct(MenuHelper $menuHelper, FlattenRouteManager $flattenRouteManager) {
            parent::__construct($menuHelper, $flattenRouteManager);
        }

        public function setFlattenRoute(FlattenRoute $flattenRoute)
        {
            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');


            while (null !== $flattenRoute = $flattenRoute->getParent()) {
                if ($flattenRoute instanceof FlattenAdminRoute) {
                    $itemFlattenRoute = $flattenRoute->getChild('index');
                    if ($itemFlattenRoute && $itemFlattenRoute->isEnabled() && null !== $item = $this->menuHelper->createItem($itemFlattenRoute)) {
                        $item->setExtra('icon', $flattenRoute->getMetaData('_icon'));
                        $item->setLabel($flattenRoute->getMetaData('_label'));
                        $root->addChild($item);
                    }

                } else {
                    if ($flattenRoute->isEnabled() && null !== $item = $this->menuHelper->createItem($flattenRoute)) {
                        $root->addChild($item);
                    }
                }


            }

            $this->setRoot($root);
            return $this;
        }




//
//        protected $menuHelper;
//        protected $fRouteManager;
//
//        public function __construct(MenuHelper $menuHelper, FlattenRouteManager $fRouteManager) {
//            parent::__construct();
//            $this->menuHelper = $menuHelper;
//            $this->fRouteManager = $fRouteManager;
//
//        }
//
//
//        public function getRoot() {
//
//            $factory = $this->menuHelper->getFactory();
//
//            $root = $factory->createItem('root');
//            $choices = $factory->createItem('test', array(
//                'label' => 'HOME',
//                'icon' => 'user',
//                'badge' => "15",
//                'uri' => '#',
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
//
//            return $root;
//        }


	}
