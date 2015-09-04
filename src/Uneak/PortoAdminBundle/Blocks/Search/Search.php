<?php

	namespace Uneak\PortoAdminBundle\Blocks\Search;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Search extends BlockModel {

		protected $link;

		public function __construct($link) {
			$this->link = $link;
		}

		/**
		 * @return mixed
		 */
		public function getLink() {
			return $this->link;
		}

		/**
		 * @param mixed $link
		 */
		public function setLink($link) {
			$this->link = $link;
		}


		public function getTemplateName() {
			return "block_search";
		}

	}
