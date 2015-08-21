<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 21/08/15
	 * Time: 16:41
	 */

	namespace Uneak\MaterialDesignBlocksBundle\Blocks;


	use Uneak\AssetsManagerBundle\Assets\AssetBuilder;
	use Uneak\AssetsManagerBundle\Assets\Js\AssetExternalJs;
	use Uneak\AssetsManagerBundle\Assets\Js\AssetInternalJs;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;

	class CardBlockTemplate extends BlockTemplate {

		public function buildAsset(AssetBuilder $builder, $parameters) {
			$builder
				->add("google_map_js", new AssetExternalJs(), array(
					"src" => "http://maps.google.com/maps/api/js?sensor=false&libraries=places"
				))
				->add("script_google_map", new AssetInternalJs(), array(
					"template"   => "block_card_script",
					"parameters" => array('item' => $parameters)
				));

		}

		public function getTemplate() {
			return "block_card_template";
		}

	}