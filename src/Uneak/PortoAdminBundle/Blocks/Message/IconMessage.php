<?php

	namespace Uneak\PortoAdminBundle\Blocks\Message;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class IconMessage extends BlockModel {

		protected $title;
		protected $description;
		protected $icon;
		protected $context;

		public function __construct($title, $description, $icon, $context = "primary") {
			$this->title = $title;
			$this->description = $description;
			$this->icon = $icon;
			$this->context = $context;
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
		 * @return mixed
		 */
		public function getIcon() {
			return $this->icon;
		}

		/**
		 * @param mixed $icon
		 */
		public function setIcon($icon) {
			$this->icon = $icon;
		}

		/**
		 * @return string
		 */
		public function getContext() {
			return $this->context;
		}

		/**
		 * @param string $context
		 */
		public function setContext($context) {
			$this->context = $context;
		}



		public function getTemplateName() {
			return "block_icon_message";
		}

	}
