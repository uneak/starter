<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 21/08/15
	 * Time: 16:41
	 */

	namespace Uneak\MaterialDesignBundle\Templates;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;

	class CardBlockTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('material_design_lite_js')
                ->add('material_design_lite_css')
				->add('card_block_script', 'internaljs', array(
					'template'   => 'block_card_script',
					'parameters' => array('item' => $parameters)
				));

		}

		public function getTemplate() {
			return 'block_card_template';
		}

	}