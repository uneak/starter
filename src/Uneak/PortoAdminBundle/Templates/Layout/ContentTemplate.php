<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class ContentTemplate extends BlockTemplate {

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
			$options['header'] = $block->getHeader();
			$options['body'] = $block->getBody();
		}

		public function getRenderTemplate() {
			return 'layout_content_template';
		}

	}