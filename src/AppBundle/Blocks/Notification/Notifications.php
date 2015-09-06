<?php

    namespace AppBundle\Blocks\Notification;

    use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
    use Uneak\PortoAdminBundle\Blocks\Message\Message;
    use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
    use Uneak\PortoAdminBundle\Blocks\Notification\Notifications as PortoAdminNotifications;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;

    class Notifications extends PortoAdminNotifications {

		public function __construct() {
            parent::__construct();

            $notificationTask = new Notification("Taches", "user", "13");
            $notificationTask->add(new ProgressBar("title", "25%", 25));
            $notificationTask->add(new ProgressBar("title", "35%", 35));
            $notificationTask->add(new ProgressBar("title", "10 ventes", 68));
            $notificationTask->add(new Message("title", "10 ventes"));
            $notificationTask->add(new Message("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes "));
            $notificationTask->add(new IconMessage("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes ", "user"));


            $this->add($notificationTask);


		}


	}
