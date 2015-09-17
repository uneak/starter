<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class EntityContent extends Block {

        protected $templateAlias = "layout_template_entity_content";

		public function __construct() {
            parent::__construct();

            $this->setHeader(new EntityHeader());
            $this->setActions(new Menu());
            $this->setBody(new PageBody());
		}


        public function setHeader($header)
        {
            $this->removeBlock("header:layout");
            $this->addBlock($header, "header:layout");
        }

        public function getHeader()
        {
            return $this->getBlock("header:layout");
        }


        public function setBody($body)
        {
            $this->removeBlock("body:layout");
            $this->addBlock($body, "body:layout");
        }

        public function getBody()
        {
            return $this->getBlock("body:layout");
        }


        public function setActions($actions)
        {
            $this->removeBlock("actions_menu:layout");
            $this->addBlock(array($actions, 'block_template_entity_content_header_menu'), "actions_menu:layout");

        }

        public function getActions()
        {
            return $this->getBlock("actions_menu:layout");
        }

	}
