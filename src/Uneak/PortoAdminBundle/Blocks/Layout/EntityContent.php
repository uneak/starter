<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class EntityContent extends Block {

        protected $templateAlias = "layout_template_entity_content";

		public function __construct() {
            parent::__construct();

            $header = new EntityHeader();
            $this->addBlock($header, "header");

            $actionsMenu = new Menu();
            $this->addBlock(array($actionsMenu, 'block_template_entity_content_header_menu'), "actions_menu");

            $body = new PageBody();
            $this->addBlock($body, "body");
		}

        public function getUniqid() {
            return $this->uniqid;
        }

        public function getHeader()
        {
            return $this->getBlock("header");
        }


        public function getBody()
        {
            return $this->getBlock("body");
        }


        /**
         * @return mixed
         */
        public function getActions()
        {
            return $this->getBlock("actions_menu");
        }

	}
