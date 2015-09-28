<?php

    namespace AppBundle\Blocks\Notification;

    use Doctrine\ORM\EntityManager;
    use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
    use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
    use Uneak\PortoAdminBundle\Blocks\Message\Message;
    use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
    use Uneak\PortoAdminBundle\Blocks\Notification\Notifications as PortoAdminNotifications;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class Notifications extends PortoAdminNotifications {

        protected $em;
        protected $uploaderHelper;
        protected $flattenRouteManager;

		public function __construct(EntityManager $em, FlattenRouteManager $flattenRouteManager, UploaderHelper $uploaderHelper) {
            parent::__construct();
            $this->em = $em;
            $this->flattenRouteManager = $flattenRouteManager;
            $this->uploaderHelper = $uploaderHelper;


            //
            $pendingAccounts = $this->em->getRepository("UserBundle:User")->findPendingAccount();

            if (count($pendingAccounts)) {

                $notificationTask = new Notification("Inscriptions", "user", count($pendingAccounts));
                foreach ($pendingAccounts as $pendingAccount) {
                    $link = $this->flattenRouteManager->getFlattenRoute('user/subject/account', array('user' => $pendingAccount->getId()))->getRoutePath();

                    $message = new Message($pendingAccount->getFirstName()." ".$pendingAccount->getLastName(), $pendingAccount->getEmail(), $this->uploaderHelper->asset($pendingAccount, 'imageFile'), $link);
                    $notificationTask->add($message);
                }

                //            $notificationTask->add(new ProgressBar("title", "25%", 25));
                //            $notificationTask->add(new ProgressBar("title", "35%", 35));
                //            $notificationTask->add(new ProgressBar("title", "10 ventes", 68));
                //            $notificationTask->add(new Message("title", "10 ventes"));
                //            $notificationTask->add(new Message("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes "));
                //            $notificationTask->add(new IconMessage("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes ", "user"));


                $this->addNotification($notificationTask);
            }

		}




        public function getNotifications() {
            return $this->getBlock(":notifications");
        }





	}
