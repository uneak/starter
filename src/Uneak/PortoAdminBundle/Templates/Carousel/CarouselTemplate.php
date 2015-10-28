<?php

	namespace Uneak\PortoAdminBundle\Templates\Carousel;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class CarouselTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_carousel_js')
			;

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['options'] = $block->getOptions();
			$options['items'] = $block->getBlock(":items");

		}


		public function getRenderTemplate() {
			return 'block_carousel_template';
		}

	}