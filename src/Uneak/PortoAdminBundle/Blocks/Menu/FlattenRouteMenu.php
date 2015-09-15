<?php

	namespace Uneak\PortoAdminBundle\Blocks\Menu;

    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;


    class FlattenRouteMenu extends Menu {

        protected $flattenRouteManager;
        protected $menuHelper;

		public function __construct(MenuHelper $menuHelper, FlattenRouteManager $flattenRouteManager) {
            parent::__construct();
            $this->flattenRouteManager = $flattenRouteManager;
            $this->menuHelper = $menuHelper;
		}

        /**
         * @param mixed $flattenRoute
         */
        public function setFlattenRoute(FlattenRoute $flattenRoute)
        {
            $this->setRoot($this->menuHelper->createMenu($flattenRoute->getMetaData('_menu'), $flattenRoute));
            return $this;
        }


        public function setPathRoute($pathRoute)
        {
            $flattenRoute = $this->flattenRouteManager->getFlattenRoute($pathRoute);
            $this->setFlattenRoute($flattenRoute);
            return $this;
        }


	}
