<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 21/08/15
	 * Time: 16:41
	 */

	namespace Uneak\MaterialDesignBlocksBundle\Blocks;

	use Uneak\AssetsManagerBundle\Assets\AssetBuilder;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;

	class CardBlockTemplate extends BlockTemplate {

		public function buildAsset(AssetBuilder $builder, $parameters) {
			$builder
				->add('material_design_lite_js', 'externaljs', array(
					'src' => 'vendor/material-design-lite/material.js'
				))
                ->add('material_design_lite_css', 'externalcss', array(
					'href' => 'vendor/material-design-lite/material.css'
				))
				->add('card_block_script', 'internalcss', array(
					'template'   => 'block_card_script',
					'parameters' => array('item' => $parameters)
				));

		}

		public function getTemplate() {
			return 'block_card_template';
		}

	}