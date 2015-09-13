<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class WidgetStatus extends Block {

        const COLOR_GREEN = "green";
        const COLOR_BLUE = "blue";
        const COLOR_PINK = "pink";
        const COLOR_ORANGE = "orange";
        const COLOR_RED = "red";



        protected $templateAlias = "block_template_widget_status";
        protected $cmpt = 1000;
        protected $status = array();

		public function __construct() {
            parent::__construct();
		}

        public function addStatus($title, $link = "#", $color = WidgetStatus::COLOR_GREEN) {
            $this->status[] = array(
                'title' => $title,
                'color' => $color,
                'link' => $link,
            );
        }

        /**
         * @return array
         */
        public function getStatus() {
            return $this->status;
        }


	}
