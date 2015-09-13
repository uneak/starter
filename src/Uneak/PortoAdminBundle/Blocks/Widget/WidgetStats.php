<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

    use Uneak\PortoAdminBundle\Blocks\Block;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;

    class WidgetStats extends Block {

        protected $templateAlias = "block_template_widget_stats";
        protected $cmpt = 1000;

        public function __construct() {
            parent::__construct();
        }

        public function addProgress(ProgressBar $progressBar) {
            $progressBar->setTemplateAlias("block_template_widget_stats_progress");
            $this->addBlock($progressBar, null, $this->cmpt--, "progressBars");

        }


	}
