<?php

	namespace Uneak\PortoAdminBundle\Blocks\Menu;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class MainMenu extends Menu {

        protected $templateAlias = "block_template_main_menu";

		public function __construct($root = null, array $parameters = array(), $renderer = null) {
			parent::__construct($root, $parameters, $renderer);
		}



	}
