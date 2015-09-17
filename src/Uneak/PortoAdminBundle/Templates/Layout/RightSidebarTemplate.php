<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class RightSidebarTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
                ->add('porto_admin_theme_scrollable_js')
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
            $options['widgets'] = $block->getBlock(":right_sidebar");
		}

		public function getRenderTemplate() {
			return 'layout_right_sidebar_template';
		}

	}