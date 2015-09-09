<?php

	namespace Uneak\PortoAdminBundle\Templates\Tabs;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class TabsTemplate extends BlockTemplate {

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

			$options['context'] = $block->getContext();
			$options['justified'] = $block->isJustified();
			$options['bottom'] = $block->isBottom();
			$options['right'] = $block->isRight();
			$options['vertical'] = $block->isVertical();
			$options['tabs'] = $block->getTabs();

		}

		public function getRenderTemplate() {
			return 'block_tabs_template';
		}

	}