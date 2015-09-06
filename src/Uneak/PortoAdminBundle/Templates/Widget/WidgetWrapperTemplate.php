<?php

	namespace Uneak\PortoAdminBundle\Templates\Widget;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class WidgetWrapperTemplate extends BlockTemplate {

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

			$options['title'] = $block->getTitle();
			$options['toggle'] = $block->isToggle();
            $options['widgets'] = $block->getBlocks("widgets");

		}

		public function getRenderTemplate() {
			return 'block_widget_wrapper_template';
		}

	}