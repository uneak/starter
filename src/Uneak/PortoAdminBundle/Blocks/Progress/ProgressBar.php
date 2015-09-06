<?php

	namespace Uneak\PortoAdminBundle\Blocks\Progress;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class ProgressBar extends BlockModel {
        protected $templateAlias = "block_template_progress_bar";

		protected $title;
		protected $percent;
		protected $value;

		public function __construct($title, $value, $percent = 0) {
			$this->title = $title;
			$this->value = $value;
			$this->percent = $percent;
		}

		/**
		 * @return mixed
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param mixed $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

		/**
		 * @return mixed
		 */
		public function getTitle() {
			return $this->title;
		}

		/**
		 * @param mixed $title
		 *
		 * @return Notification
		 */
		public function setTitle($title) {
			$this->title = $title;

			return $this;
		}

		/**
		 * @return int
		 */
		public function getPercent() {
			return $this->percent;
		}

		/**
		 * @param int $percent
		 */
		public function setPercent($percent) {
			$this->percent = $percent;
		}




	}
