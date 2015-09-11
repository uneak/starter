<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    class LeftSidebar extends Sidebar {

        protected $templateAlias = "layout_template_left_sidebar";
		protected $title;
        protected $uniqid;

        public function __construct($title = "") {
            $this->title = $title;
            $this->uniqid = uniqid('comp_');
        }

        public function getUniqid() {
            return $this->uniqid;
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
