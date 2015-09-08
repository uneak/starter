<?php

	namespace Uneak\PortoAdminBundle\Templates\Carousel;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class CarouselTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_carousel_js')
			;

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {

			$options['options'] = $block->getOptions();
			$options['items'] = $block->getItems();

		}

		public function getRenderTemplate() {
			return 'block_carousel_template';
		}

	}