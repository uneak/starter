<?php

	namespace Uneak\PortoAdminBundle\Templates\Teaser;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class TeaserTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
//			$builder
//				->add('porto_admin_theme_init_toggle_js')
//            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['icon'] = $block->getIcon();
			$options['description'] = $block->getDescription();
			$options['context'] = $block->getContext();
			$options['header_context'] = $block->getHeaderContext();
			$options['horizontal'] = $block->isHorizontal();

		}

		public function getRenderTemplate() {
			return 'block_teaser_template';
		}

	}