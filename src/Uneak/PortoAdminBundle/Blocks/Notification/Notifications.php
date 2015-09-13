<?php

	namespace Uneak\PortoAdminBundle\Blocks\Notification;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Notifications extends Block {
        protected $templateAlias = "block_template_notifications";
		protected $cmpt = 1000;

		public function __construct() {
            parent::__construct();
		}

		public function addNotification(Notification $notification) {
			$this->addBlock($notification, null, $this->cmpt--, "notifications");
		}

        public function getNotifications() {
            return $this->getBlocks("notifications");
        }


	}
