<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class EntitySidebar extends Sidebar {

        protected $templateAlias = "layout_template_entity_sidebar";

        public function __construct() {
            parent::__construct();
        }

        public function addWidget($id, $widget, $wrap = true, $priority = null) {
            if ($widget instanceof Menu) {
                $widget->setTemplateAlias("block_template_entity_menu");
            }
            return parent::addWidget($id, $widget, $wrap, $priority);
        }



	}
