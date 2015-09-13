<?php

	namespace AppBundle\Blocks\Menu;

	use Uneak\PortoAdminBundle\Blocks\Menu\Menu as PortoAdminMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;

    class UserMenu extends PortoAdminMenu {

        protected $menuHelper;
        protected $fRouteManager;

        public function __construct(MenuHelper $menuHelper, FlattenRouteManager $fRouteManager) {
            parent::__construct();
            $this->menuHelper = $menuHelper;
            $this->fRouteManager = $fRouteManager;

        }

        public function getRoot() {

            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');
            $choices = $factory->createItem('top-separator', array(
                'attributes' => array('class' => 'divider'),
            ));
            $root->addChild($choices);

            if (null !== $itemNews = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('user/index'))) {
                $itemNews->setExtra("badge", "19");
                $itemNews->setExtra("badge_context", "danger");
                $itemNews->setLinkAttribute("role", "menuitem");
                $itemNews->setLinkAttribute("tabindex", "-1");
                $root->addChild($itemNews);
            }

            $choices = $factory->createItem('bottom-separator', array(
                'attributes' => array('class' => 'divider'),
            ));
            $root->addChild($choices);

            if (null !== $itemNews2 = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('admin'))) {
                $itemNews2->setExtra("badge", "15");
                $itemNews2->setLinkAttribute("role", "menuitem");
                $itemNews2->setLinkAttribute("tabindex", "-1");
                $root->addChild($itemNews2);
            }



            return $root;
        }

	}
