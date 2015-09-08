<?php

	namespace Uneak\PortoAdminBundle\Blocks\Carousel;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Carousel extends BlockModel {

        protected $templateAlias = "block_template_carousel";
		protected $options = array();
		protected $items = array();

		public function __construct() {
		}

		/**
		 * @return array
		 */
		public function getItems() {
			return $this->items;
		}

		/**
		 * @param array $items
		 */
		public function setItems($items) {
			$this->items = $items;
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
