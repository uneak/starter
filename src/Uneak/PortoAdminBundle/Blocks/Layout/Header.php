<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;

    class Header extends Block {

        protected $templateAlias = "layout_template_header";

		public function __construct() {
            parent::__construct();
            $this->setBrand("block_brand");
            $this->setSearch(new Search());
            $this->setNotifications("block_notifications");
            $this->setUser("block_user");

		}

        public function getBrand()
        {
            return $this->getBlock("brand:layout");
        }

        public function setBrand($brand)
        {
            $this->removeBlock("brand:layout");
            $this->addBlock(array($brand, "block_template_brand_main_ui"), "brand:layout");
        }

        public function getSearch()
        {
            return $this->getBlock("search:layout");
        }

        public function setSearch($search)
        {
            $this->removeBlock("search:layout");
            $this->addBlock($search, "search:layout");
        }

        public function getNotifications()
        {
            return $this->getBlock("notifications:layout");
        }

        public function setNotifications($notifications)
        {
            $this->removeBlock("notifications:layout");
            $this->addBlock($notifications, "notifications:layout");
        }

        public function getUser()
        {
            return $this->getBlock("user:layout");
        }

        public function setUser($user)
        {
            $this->removeBlock("user:layout");
            $this->addBlock($user, "user:layout");
        }


	}
