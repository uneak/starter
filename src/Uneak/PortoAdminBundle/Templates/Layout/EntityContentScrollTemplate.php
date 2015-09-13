<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityContentScrollTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['subtitle'] = $block->getSubtitle();
			$options['body'] = $block->getBody();
		}

		public function getRenderTemplate() {
			return 'layout_entity_content_scroll_template';
		}

	}