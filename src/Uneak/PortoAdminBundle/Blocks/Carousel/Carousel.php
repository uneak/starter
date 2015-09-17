<?php

	namespace Uneak\PortoAdminBundle\Blocks\Carousel;

    use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
    use Uneak\PortoAdminBundle\Blocks\Block;

    class Carousel extends Block {

        protected $templateAlias = "block_template_carousel";
		protected $options = array();

		public function __construct() {
            parent::__construct();
		}


        public function addItem(BlockInterface $block) {
            $this->addBlock($block, ":items");
        }

        public function getItems() {
            return $this->getBlock(":items");
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
