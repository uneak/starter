<?php

	namespace Uneak\PortoAdminBundle\Templates\Counter;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class CounterTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
//			$builder
//				->add('porto_admin_theme_init_toggle_js')
//            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['icon'] = $block->getIcon();
			$options['value'] = $block->getValue();
			$options['comment'] = $block->getComment();
			$options['context'] = $block->getContext();
			$options['featured'] = $block->getFeatured();
			$options['size'] = $block->getSize();

		}

		public function getRenderTemplate() {
			return 'block_counter_template';
		}

	}