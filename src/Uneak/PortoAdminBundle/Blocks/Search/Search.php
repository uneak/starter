<?php

	namespace Uneak\PortoAdminBundle\Blocks\Search;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Search extends BlockModel {
        protected $templateAlias = "block_template_search";

		protected $link;

		public function __construct($link = null) {
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



	}