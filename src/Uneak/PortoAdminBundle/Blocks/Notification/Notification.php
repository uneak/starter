<?php

	namespace Uneak\PortoAdminBundle\Blocks\Notification;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

	class Notification extends BlockModel {

		protected $title;
		protected $icon;
		protected $badge;
		protected $cmpt = 1000;


		public function __construct($title, $icon, $badge = null) {
			$this->title = $title;
			$this->icon = $icon;
			$this->badge = $badge;
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
		 * @return mixed
		 */
		public function getIcon() {
			return $this->icon;
		}

		/**
		 * @param mixed $icon
		 *
		 * @return Notification
		 */
		public function setIcon($icon) {
			$this->icon = $icon;

			return $this;
		}

		/**
		 * @return null
		 */
		public function getBadge() {
			return $this->badge;
		}

		/**
		 * @param null $badge
		 *
		 * @return Notification
		 */
		public function setBadge($badge) {
			$this->badge = $badge;

			return $this;
		}


		public function add(BlockModelInterface $block) {
			$this->addBlock($block, null, $this->cmpt--, "notification_item");
		}

		public function getTemplateName() {
			return "block_notification";
		}

	}
