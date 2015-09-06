<?php

    namespace AppBundle\Blocks\Menu;

	use Uneak\PortoAdminBundle\Blocks\Menu\MainMenu as PortoAdminMainMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;

    class MainMenu extends PortoAdminMainMenu {

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
            $choices = $factory->createItem('test', array(
                'label' => 'choix',
                'icon' => 'user'
            ));
            $root->addChild($choices);
            $choices2 = $factory->createItem('test2', array(
                'label' => 'choiXx',
                'icon' => 'user'
            ));
            $root->addChild($choices2);

            if (null !== $itemNews = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('user/index'))) {
                $itemNews->setExtra("badge", "15");
                $itemNews->setExtra("badge_context", "danger");
                $choices->addChild($itemNews);
            }

            if (null !== $itemNews2 = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('admin'))) {
                $itemNews2->setExtra("badge", "15");
                $choices->addChild($itemNews2);
            }

            return $root;
        }


	}