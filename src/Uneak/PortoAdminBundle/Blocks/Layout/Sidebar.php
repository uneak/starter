<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetWrapper;

    class Sidebar extends Block {

        protected $templateAlias = "layout_template_sidebar";

		public function __construct() {
            parent::__construct();
		}

        public function addWidget($id, $widget, $wrap = true, $priority = null) {
            if ($wrap) {
                $widgetWrapper = new WidgetWrapper($id, true);
                $widgetWrapper->addWidget($widget);
                $this->addBlock($widgetWrapper, $id.":widgets", $priority);
            } else {
                $this->addBlock($widget, $id.":widgets", $priority);
            }

            return $this;
        }

        public function removeWidget($id) {
            $this->removeBlock($id.":widgets");
        }

        public function getWidget($id) {
            return $this->getBlock($id.":widgets");
        }

        public function getWidgets() {
            return $this->getBlock(":widgets");
        }
	}
