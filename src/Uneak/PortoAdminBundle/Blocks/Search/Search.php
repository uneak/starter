<?php

	namespace Uneak\PortoAdminBundle\Blocks\Search;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Search extends Block {
        protected $templateAlias = "block_template_search";

		protected $link;
		protected $inputName;

		public function __construct($link = null) {
            parent::__construct();
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

		/**
		 * @return mixed
		 */
		public function getInputName() {
			return $this->inputName;
		}

		/**
		 * @param mixed $inputName
		 */
		public function setInputName($inputName) {
			$this->inputName = $inputName;
		}




	}
