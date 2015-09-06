<?php

    namespace AppBundle\Blocks\Brand;

	use Uneak\PortoAdminBundle\Blocks\Brand\Brand as PortoAdminBrand;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;

    class Brand extends PortoAdminBrand {

        protected $menuHelper;
        protected $fRouteManager;

        public function __construct(MenuHelper $menuHelper, FlattenRouteManager $fRouteManager) {
            parent::__construct();
            $this->menuHelper = $menuHelper;
            $this->fRouteManager = $fRouteManager;
            $this->name = "Starter";
            $this->photo = "bundles/uneakportoadmin/images/volkswagen_logo.jpg";
        }

        public function getLink() {
            return "#";
        }

	}
