<?php

	namespace Uneak\PortoAdminBundle\Templates\Accordion;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class AccordionTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_toggle_js')
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {

			$options['collapse_other'] = $block->isCollapseOther();
			$options['toggle'] = $block->isToggle();
			$options['tabs'] = $block->getTabs();

		}

		public function getRenderTemplate() {
			return 'block_accordion_template';
		}

	}