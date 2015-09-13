<?php

	namespace Uneak\PortoAdminBundle\Blocks\Carousel;

    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
    use Uneak\PortoAdminBundle\Blocks\Block;

    class Carousel extends Block {

        protected $templateAlias = "block_template_carousel";
        protected $cmpt = 1000;
		protected $options = array();

		public function __construct() {
            parent::__construct();
		}


        public function addItem(BlockModelInterface $block) {
            $this->addBlock($block, null, $this->cmpt--, "items");
        }

        public function getItems() {
            return $this->getBlocks("items");
        }

		/**
		 * @return array
		 */
		public function getOptions() {
			return $this->options;
		}

		/**
		 * @param array $options
		 */
		public function setOptions($options) {
			$this->options = $options;
		}

	}
