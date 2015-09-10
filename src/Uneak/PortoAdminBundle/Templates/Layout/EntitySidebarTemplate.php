<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntitySidebarTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_scrollable_js')
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            $options['widgets'] = $block->getWidgets();
            $options['photo'] = $block->getPhoto();
		}

		public function getRenderTemplate() {
			return 'layout_entity_sidebar_template';
		}

	}