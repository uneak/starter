<?php

	namespace Uneak\PortoAdminBundle\Templates\Photo;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class PhotoTemplate extends BlockTemplate {

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
			$options['photo'] = $block->getPhoto();
			$options['filter'] = 'porto_admin_entity_photo';
			$options['title'] = $block->getTitle();
			$options['description'] = $block->getDescription();

		}

		public function getRenderTemplate() {
			return 'block_photo_template';
		}

	}