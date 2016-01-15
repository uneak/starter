<?php

	namespace Uneak\PortoAdminBundle\Templates\Notification;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class LinkedProgressBarTemplate extends ProgressBarTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			parent::buildAsset($builder, $parameters);

			$options = array();
			$options['uniqid'] = $parameters->getUniqid();
			$options['url'] = $parameters->getUrl();
			$options['title'] = $parameters->getTitle();
			$options['value'] = $parameters->getValue();
			$options['percent'] = $parameters->getPercent();


			$builder
				->add('linked_progressbar_script', 'internaljs', array(
					'template'   => 'linked_progressbar_script',
					'parameters' => $options,
				));
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['url'] = $block->getUrl();

		}

		public function getRenderTemplate() {
			return 'block_progress_bar_notification_template';
		}

	}