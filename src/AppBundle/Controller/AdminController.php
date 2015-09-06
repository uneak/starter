<?php

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
	use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
	use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetWrapper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Doctrine\ORM\Query\Expr;

	class AdminController extends Controller {


		public function indexAction(FlattenRoute $route, Request $request) {


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");
//
//            $layoutLeftSidebar = $blockBuilder->getBlock('layout/left_sidebar');
//            $layoutContentHeader = $blockBuilder->getBlock('layout/content/header');
//            $layoutNotifications = $blockBuilder->getBlock('layout/header/notifications');
//            $layoutSearch = $blockBuilder->getBlock('layout/header/search');
//
//            $layoutContentHeader->setTitle("Page principale");
//
//			$notificationTask = new Notification("Taches", "users", "1");
//			$notificationTask->add(new IconMessage("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes ", "user"));
//            $layoutNotifications->add($notificationTask);
//
//            $layoutSearch->setLink("http://uneak.fr");
//
//
//            $widgetStats = new WidgetStats();
//            $widgetStats->addProgress(new ProgressBar("title", "25%", 25));
//            $widgetStats->addProgress(new ProgressBar("title", "35%", 35));
//            $widgetStats->addProgress(new ProgressBar("title", "10 ventes", 68));
//
//            $widgetWrapper = new WidgetWrapper("STATS", true);
//            $widgetWrapper->add($widgetStats);
//
//            $layoutLeftSidebar->addWidget("stats", $widgetWrapper);

            return $blockBuilder->render("layout");
//			return $this->render('{{ renderBlock("layout") }}');



		}


	}
