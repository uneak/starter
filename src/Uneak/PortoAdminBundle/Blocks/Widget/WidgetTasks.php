<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class WidgetTasks extends Block {

        protected $templateAlias = "block_template_widget_tasks";
        protected $cmpt = 1000;
        protected $tasks = array();

		public function __construct() {
            parent::__construct();
		}

        public function addTask($title, $link) {
            $this->tasks[] = array(
                'title' => $title,
                'link' => $link,
            );
        }

        /**
         * @return array
         */
        public function getTasks() {
            return $this->tasks;
        }


	}
