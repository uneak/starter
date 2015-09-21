<?php

	namespace Uneak\PortoAdminBundle\Templates\Brand;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class BrandFormUITemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
//			$builder
//				->add('material_design_lite_js')
//                ->add('material_design_lite_css')
//				->add('card_block_script', 'internaljs', array(
//					'template'   => 'block_card_script',
//					'parameters' => array('item' => $parameters)
//				));
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['link'] = $block->getLink();
			$options['name'] = $block->getName();
			$options['photo'] = $block->getPhoto();
			$options['filter'] = 'porto_admin_brand_photo_54';
			$options['classes'] = $options['classes'] . " pull-left";
		}

		public function getRenderTemplate() {
			return 'block_brand_form_ui_template';
		}

	}