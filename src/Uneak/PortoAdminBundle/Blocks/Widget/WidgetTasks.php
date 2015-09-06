<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

    class WidgetTasks extends BlockModel {

        protected $templateAlias = "block_template_widget_tasks";
        protected $cmpt = 1000;
        protected $tasks = array();

		public function __construct() {
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
