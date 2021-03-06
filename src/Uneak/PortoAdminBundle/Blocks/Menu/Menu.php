<?php

	namespace Uneak\PortoAdminBundle\Blocks\Menu;

	use Knp\Menu\ItemInterface;
    use Uneak\PortoAdminBundle\Blocks\Block;

    class Menu extends Block {

        protected $templateAlias = "block_template_menu";

        protected $root;
		protected $renderer;
		protected $parameters;

		public function __construct($root = null, array $parameters = array(), $renderer = null) {
            parent::__construct();
			$this->root = $root;
			$this->renderer = $renderer;
			$this->parameters = $parameters;
		}

		public function getParameters() {
			return $this->parameters;
		}

		public function setParameters($parameters) {
			$this->parameters = $parameters;
		}

		public function getRenderer() {
			return $this->renderer;
		}

		public function setRenderer($renderer) {
			$this->renderer = $renderer;
		}

		public function getRoot() {
			return $this->root;
		}

		public function setRoot(ItemInterface $root) {
			$this->root = $root;
			return $this;
		}


	}
