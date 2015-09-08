<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class LeftSidebarTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_sidebar_widget_js')
				->add('porto_admin_theme_bootstrap_toggle_js')
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
			$options['title'] = $block->getTitle();
            $options['widgets'] = $block->getWidgets();
		}

		public function getRenderTemplate() {
			return 'layout_left_sidebar_template';
		}

	}