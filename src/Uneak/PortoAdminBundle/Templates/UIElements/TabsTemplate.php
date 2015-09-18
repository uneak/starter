<?php

	namespace Uneak\PortoAdminBundle\Templates\UIElements;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class TabsTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder->add('porto_admin_uielements_tabs_css');
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['context'] = $block->getContext();
			$options['justified'] = $block->isJustified();
			$options['bottom'] = $block->isBottom();
			$options['right'] = $block->isRight();
			$options['vertical'] = $block->isVertical();
			$options['tabs'] = $block->getTabs();

		}

		public function getRenderTemplate() {
			return 'block_tabs_template';
		}

	}