<?php

	namespace Uneak\PortoAdminBundle\Templates\Content;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class ContentTemplate extends BlockTemplate {

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
			$options['template'] = $block->getContent();
		}

		public function getRenderTemplate() {
			return 'content';
		}

	}