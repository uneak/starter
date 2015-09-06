<?php

	namespace Uneak\PortoAdminBundle\Templates\Widget;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\PortoAdminBundle\Templates\Notification\ProgressBarTemplate;

	class WidgetStatsProgressTemplate extends ProgressBarTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
            parent::buildAsset($builder, $parameters);
		}

		public function getRenderTemplate() {
			return 'block_widget_stats_progress_template';
		}

	}