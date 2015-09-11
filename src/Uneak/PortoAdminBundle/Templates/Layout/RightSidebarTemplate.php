<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class RightSidebarTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
//				->add('porto_admin_theme_init_sidebar_widget_js')
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            $options['widgets'] = $block->getBlocks("right_sidebar");
		}

		public function getRenderTemplate() {
			return 'layout_right_sidebar_template';
		}

	}