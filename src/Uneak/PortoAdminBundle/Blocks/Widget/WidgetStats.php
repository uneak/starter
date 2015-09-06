<?php

	namespace Uneak\PortoAdminBundle\Blocks\Widget;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;

    class WidgetStats extends BlockModel {

        protected $templateAlias = "block_template_widget_stats";
        protected $cmpt = 1000;

        public function addProgress(ProgressBar $progressBar) {
            $progressBar->setTemplateAlias("block_template_widget_stats_progress");
            $this->addBlock($progressBar, null, $this->cmpt--, "progressBars");

        }


	}
