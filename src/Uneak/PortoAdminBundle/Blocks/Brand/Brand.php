<?php

	namespace Uneak\PortoAdminBundle\Blocks\Brand;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Brand extends BlockModel {

		protected $link;
		protected $name;
		protected $photo;

		public function __construct($name, $link, $photo = null) {
			$this->name = $name;
			$this->link = $link;
			$this->photo = $photo;
		}

		/**
		 * @return mixed
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @param mixed $name
		 */
		public function setName($name) {
			$this->name = $name;
		}

		/**
		 * @return null
		 */
		public function getPhoto() {
			return $this->photo;
		}

		/**
		 * @param null $photo
		 */
		public function setPhoto($photo) {
			$this->photo = $photo;
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
			return "block_brand";
		}

	}
