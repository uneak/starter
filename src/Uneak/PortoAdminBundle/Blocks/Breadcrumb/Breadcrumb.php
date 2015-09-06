<?php

	namespace Uneak\PortoAdminBundle\Blocks\Breadcrumb;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

	class Breadcrumb extends Menu {

        protected $templateAlias = "block_template_breadcrumb";

		public function __construct($root = null, array $parameters = array(), $renderer = null) {
			parent::__construct($root, $parameters, $renderer);
		}


	}
