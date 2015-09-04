<?php

	namespace Uneak\PortoAdminBundle\Blocks\Message;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Message extends BlockModel {

		protected $title;
		protected $description;
		protected $photo;

		public function __construct($title, $description = null, $photo = null) {
			$this->title = $title;
			$this->description = $description;
			$this->photo = $photo;
		}

		/**
		 * @return mixed
		 */
		public function getTitle() {
			return $this->title;
		}

		/**
		 * @param mixed $title
		 */
		public function setTitle($title) {
			$this->title = $title;
		}

		/**
		 * @return null
		 */
		public function getDescription() {
			return $this->description;
		}

		/**
		 * @param null $description
		 */
		public function setDescription($description) {
			$this->description = $description;
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

		public function getTemplateName() {
			return "block_message";
		}

	}
