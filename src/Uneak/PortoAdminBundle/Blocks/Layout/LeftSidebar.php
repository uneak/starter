<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    class LeftSidebar extends Sidebar {

        protected $templateAlias = "layout_template_left_sidebar";
		protected $title;

        public function __construct($title = "") {
            $this->title = $title;
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
