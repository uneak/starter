<?php

	namespace Uneak\PortoAdminBundle\Blocks\Brand;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Brand extends Block {

        protected $templateAlias = "block_template_brand";
		protected $link;
		protected $name;
		protected $photo;
		protected $filter = 'porto_admin_brand_photo_35';

		public function __construct($name = null, $link = null, $photo = null) {
            parent::__construct();
			$this->name = $name;
			$this->link = $link;
			$this->photo = $photo;
		}

		/**
		 * @return string
		 */
		public function getFilter() {
			return $this->filter;
		}

		/**
		 * @param string $filter
		 */
		public function setFilter($filter) {
			$this->filter = $filter;
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


	}
