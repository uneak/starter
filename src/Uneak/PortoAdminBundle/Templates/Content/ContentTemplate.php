<?php

	namespace Uneak\PortoAdminBundle\Templates\Content;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class ContentTemplate extends BlockTemplate {

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['template'] = $block->getContent();
		}

		public function getRenderTemplate() {
			return 'content';
		}

	}