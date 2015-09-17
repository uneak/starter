<?php

	namespace Uneak\PortoAdminBundle\Templates\Widget;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class WidgetTasksTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['tasks'] = $block->getTasks();

		}

		public function getRenderTemplate() {
			return 'block_widget_tasks_template';
		}

	}