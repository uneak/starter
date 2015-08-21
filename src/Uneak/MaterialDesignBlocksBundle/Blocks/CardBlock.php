<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 21/08/15
	 * Time: 16:41
	 */

	namespace Uneak\MaterialDesignBlocksBundle\Blocks;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class CardBlock extends BlockModel {

		public function getMarc() {
			return "galoyer";
		}

		public function getBlockName() {
			return "block_card_model";
		}

	}