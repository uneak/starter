<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class LeftSidebar extends Sidebar {

        protected $templateAlias = "layout_template_left_sidebar";
		protected $title;

        public function __construct($title = "") {
            $this->title = $title;
        }

        public function addWidget($id, $widget, $wrap = true, $priority = null) {
            if ($widget instanceof Menu) {
                $widget->setTemplateAlias("block_template_main_menu");
            }
            return parent::addWidget($id, $widget, $wrap, $priority);
        }


        public function getTitle()
        {
            return $this->title;
        }


        public function setTitle($title)
        {
            $this->title = $title;
            return $this;
        }




	}
