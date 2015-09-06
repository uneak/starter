<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;

    class Header extends BlockModel {

        protected $templateAlias = "layout_template_header";

		public function __construct() {
            $this->setBrand("block_brand");
            $this->setSearch(new Search());
            $this->setNotifications("block_notifications");
            $this->setUser("block_user");

		}

        public function getBrand()
        {
            return $this->getBlock("brand");
        }

        public function setBrand($brand)
        {
            $this->removeBlock("brand");
            $this->addBlock($brand, "brand");
        }

        public function getSearch()
        {
            return $this->getBlock("search");
        }

        public function setSearch($search)
        {
            $this->removeBlock("search");
            $this->addBlock($search, "search");
        }

        public function getNotifications()
        {
            return $this->getBlock("notifications");
        }

        public function setNotifications($notifications)
        {
            $this->removeBlock("notifications");
            $this->addBlock($notifications, "notifications");
        }

        public function getUser()
        {
            return $this->getBlock("user");
        }

        public function setUser($user)
        {
            $this->removeBlock("user");
            $this->addBlock($user, "user");
        }


	}
