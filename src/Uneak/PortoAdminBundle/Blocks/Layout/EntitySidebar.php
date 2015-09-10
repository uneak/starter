<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;


    class EntitySidebar extends Sidebar {

        protected $templateAlias = "layout_template_entity_sidebar";
		protected $photo;

        public function __construct() {
        }

        /**
         * @return mixed
         */
        public function getPhoto()
        {
            return $this->photo;
        }

        /**
         * @param mixed $photo
         */
        public function setPhoto($photo)
        {
            $this->photo = $photo;
        }

	}
