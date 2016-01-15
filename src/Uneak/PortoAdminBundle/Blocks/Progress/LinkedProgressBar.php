<?php

	namespace Uneak\PortoAdminBundle\Blocks\Progress;


    class LinkedProgressBar extends ProgressBar {

        protected $templateAlias = "block_template_linked_progress_bar";

		/**
		 * @var
		 */
		private $url;


		public function __construct($title, $value, $percent = 0, $url) {
            parent::__construct($title, $value, $percent);
			$this->url = $url;
		}

		/**
		 * @return mixed
		 */
		public function getUrl() {
			return $this->url;
		}

		/**
		 * @param mixed $url
		 */
		public function setUrl($url) {
			$this->url = $url;
		}




	}
