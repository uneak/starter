<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    class EntityHeader extends Sidebar {

        protected $templateAlias = "layout_template_entity_header";
        protected $title;


		public function __construct() {
            parent::__construct();
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




	}
