<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityHeaderTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
			$options['title'] = $block->getTitle();
			$options['actions'] = $block->getActions();


//            protected $actions;
//            protected $rightBlocks;

		}

		public function getRenderTemplate() {
			return 'layout_entity_header_template';
		}

	}