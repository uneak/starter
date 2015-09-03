<?php

	namespace Uneak\PortoAdminBundle\Blocks\Breadcrumb;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

	class Breadcrumb extends BlockModel {

		public function __construct() {
		}

		public function getBlockName() {
			return "block_breadcrumb";
		}

	}
