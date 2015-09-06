<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

    class Sidebar extends BlockModel {

        protected $templateAlias = "layout_template_sidebar";
        protected $cmpt = 1000;

		public function __construct() {
		}

        public function addWidget($id, $widget, $priority = null) {
            $priority = (is_null($priority)) ? $this->cmpt-- : $priority;
            $this->addBlock($widget, $id, $priority);
        }

        public function removeWidget($id) {
            $this->removeBlock($id);
        }

        public function getWidget($id) {
            return $this->getBlock($id);
        }

        public function getWidgets() {
            return $this->getBlocks();
        }
	}
