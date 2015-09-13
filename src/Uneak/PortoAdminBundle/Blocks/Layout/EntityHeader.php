<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class EntityHeader extends Sidebar {

        protected $templateAlias = "layout_template_entity_header";
        protected $title;


		public function __construct() {
            parent::__construct();
            $actionsMenu = new Menu();
            $this->addBlock(array($actionsMenu, 'block_template_entity_content_header_menu'), "actions_menu");
		}

        public function addWidget($id, $widget, $wrap = true, $priority = null) {
            $priority = (is_null($priority)) ? $this->cmpt-- : $priority;
            $this->addBlock($widget, $id, $priority, "widgets");
            return $this;
        }

        /**
         * @return mixed
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getActions()
        {
            return $this->getBlock("actions_menu");
        }


	}
