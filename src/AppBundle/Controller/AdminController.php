<?php

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Carousel\Carousel;
	use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
	use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetWrapper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Doctrine\ORM\Query\Expr;

	class AdminController extends Controller {


		public function indexAction(FlattenRoute $route, Request $request) {


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

			$body = $blockBuilder->getBlock('layout/content/body');


			$carousel = new Carousel();


			$panel = new Panel();
			$panel->setTitle("Hello");
			$panel->setSubtitle("World");
			$panel->setToggle(true);
			$panel->setDismiss(true);
			$panel->setFooter("Marc galoyer");
			$panel->setCollapsed(false);
			$panel->setFeaturedContext("primary");
			$panel->setContext("caca");
			$panel->setTransparent(false);
			$panel->setHeaderTransparent(false);
			$panel->addBlock($carousel);
			$body->addBlock($panel);

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
