<?php

	namespace Uneak\PortoAdminBundle\Blocks\Notification;

	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
    use Uneak\PortoAdminBundle\Blocks\Block as PortoAdminBlock;

    class Notification extends PortoAdminBlock {
        protected $templateAlias = "block_template_notification";

		protected $title;
		protected $icon;
		protected $badge;


		public function __construct($title, $icon, $badge = null) {
            parent::__construct();
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


		public function add(BlockInterface $block) {
			$this->addBlock($block, ":notification_item");
		}


		public function getNotification() {
			return $this->getBlock(":notification_item");
		}


	}
