<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

    class WidgetWrapper extends BlockModel {

        protected $templateAlias = "block_template_widget_wrapper";
        protected $cmpt = 1000;
        protected $title;
		protected $toggle = true;

		public function __construct($title, $toggle = true) {
			$this->title = $title;
			$this->toggle = $toggle;
		}

        public function add(BlockModelInterface $widget) {
            $this->addBlock($widget, null, $this->cmpt--, "widgets");
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
