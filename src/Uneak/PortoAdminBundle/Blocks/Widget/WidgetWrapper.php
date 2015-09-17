<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class WidgetWrapper extends Block {

        protected $templateAlias = "block_template_widget_wrapper";
        protected $title;
		protected $toggle = true;



		public function __construct($title, $toggle = true) {
            parent::__construct();
			$this->title = $title;
			$this->toggle = $toggle;
		}

        public function getUniqid() {
            return $this->uniqid;
        }

        public function addWidget($widget) {
            $this->addBlock($widget, ":widgets");
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
         * @return boolean
         */
        public function isToggle()
        {
            return $this->toggle;
        }

        /**
         * @param boolean $toggle
         */
        public function setToggle($toggle)
        {
            $this->toggle = $toggle;
        }


	}
