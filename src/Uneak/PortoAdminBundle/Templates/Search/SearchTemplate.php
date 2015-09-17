<?php

	namespace Uneak\PortoAdminBundle\Templates\Search;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class SearchTemplate extends BlockTemplate {

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

		}

		public function getRenderTemplate() {
			return 'block_search_template';
		}

	}