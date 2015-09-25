<?php

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Accordion\Accordion;
    use Uneak\PortoAdminBundle\Blocks\Carousel\Carousel;
    use Uneak\PortoAdminBundle\Blocks\Content\Content;
    use Uneak\PortoAdminBundle\Blocks\Counter\Counter;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\MainInterface;
    use Uneak\PortoAdminBundle\Blocks\Menu\EntityMenu;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
	use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\PortoAdminBundle\Blocks\UIElements\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Teaser\Teaser;
    use Uneak\PortoAdminBundle\Blocks\User\UserBadge;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetWrapper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Doctrine\ORM\Query\Expr;

	class AdminController extends Controller {


		public function indexAction(FlattenRoute $route, Request $request) {


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

			$body = $blockBuilder->getBlock('layout/content/body');
            $layoutSideBar = $blockBuilder->getBlock('layout/left_sidebar');
			$layout = $blockBuilder->getBlock('layout');

            $layout->setLeftSidebarCollapsed(true);
//            $layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);



            $entityLayout = new Entity();
            $entitySidebar = $entityLayout->getEntitySidebar();

            $entityLayoutHeader = $entityLayout->getContent()->getHeader();
            $entityLayoutHeader->setTitle("Uneak");
//            $entityLayout->getContent()->setTitle("Uneak");
//            $entityLayout->getContent()->setSubtitle('From <a href="#">Okler Themes</a> to <a href="#">You</a>, started on July, 05, 2014');



            $menuHelper = $this->get("uneak.routesmanager.menu.helper");
            $fRouteManager = $this->get("uneak.routesmanager.flattenmanager");

            $factory = $menuHelper->getFactory();
            $root = $factory->createItem('root');

            $choices = $factory->createItem('test', array(
                'label' => 'choix',
                'icon' => 'user',
                'badge' => '15',
                'badge_context' => 'warning',
            ));
            $root->addChild($choices);

            $choices2 = $factory->createItem('test2', array(
                'label' => 'choiXx',
                'icon' => 'users',
                'context' => 'danger'
            ));
            $root->addChild($choices2);

            if (null !== $itemNews = $menuHelper->createItem($fRouteManager->getFlattenRoute('user/index'))) {
                $itemNews->setExtra("badge", "15");
                $itemNews->setExtra("badge_context", "danger");
                $choices->addChild($itemNews);
            }

            if (null !== $itemNews2 = $menuHelper->createItem($fRouteManager->getFlattenRoute('admin'))) {
                $itemNews2->setExtra("badge", "15");
                $choices->addChild($itemNews2);
            }



//            $entityLayout->getToolbar()->setRoot($root);
            $entitySidebarMenu = new Menu();
            $entitySidebarMenu->setRoot($root);
            $entitySidebar->addWidget("menu", $entitySidebarMenu, false, 9999);

//
            $entityLayout->getContent()->getActions()->setRoot($root);
            $search = new Search("#");
            $entityLayoutHeader->addWidget("search", $search);
//
            $body->addBlock($entityLayout);


			$carousel = new Carousel();
            $carousel->setOptions(array(
                'autoPlay' => 3000,
                'items' => 4,
                'itemsDesktop' => array(1199,4),
                'itemsDesktopSmall' => array(979,3),
                'itemsTablet' => array(768,2),
                'itemsMobile' => array(479,1),

            ));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $carousel->addItem(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));




			$panel = new Panel();
			$panel->setTitle("Hello");
			$panel->setSubtitle("World");
			$panel->setToggle(true);
			$panel->setBadge(158);
			$panel->setBadgeContext("primary");
			$panel->setDismiss(true);
			$panel->setFooter("Marc galoyer");
			$panel->setCollapsed(false);
			$panel->setFeaturedContext("primary");
			$panel->setContext("caca");
			$panel->setTransparent(false);
			$panel->setHeaderTransparent(false);

            $panel->addAction("user", "utilisateur", "http://www.uneak.fr");

			$panel->addBlock($carousel);


            $tabs = new Tabs();
            $tabs->setContext("primary");
            $tabs->setRight(false);
            $tabs->setBottom(false);
            $tabs->setJustified(false);
            $tabs->setVertical(false);

            $tabs->addTab('user', 'Utilisateur', new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $tabs->addTab(null, 'Deux', new Content("Hello<br/><img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $tabs->addTab('user', 'Trois', new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));


            $accordion = new Accordion();
            $accordion->setToggle(true);
            $accordion->setCollapseOther(false);

            $accordion->addTab('user', 'Utilisateur', null, new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $accordion->addTab(null, 'Deux', 'primary', new Content("Hello<br/><img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $accordion->addTab('user', 'Trois', 'danger', new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));



            $counter = new Counter();
            $counter->setTitle("Utilisateurs");
            $counter->setIcon("users");
            $counter->setComment("(non connecté)");
            $counter->setContext("danger");
            $counter->setValue("58");
            $counter->setSize(Counter::SIZE_XLG);
//            $counter->setFeatured(Counter::FEATURED_NONE);


            $teaser = new Teaser();
            $teaser->setTitle("Utilisateurs");
            $teaser->setIcon("users");
            $teaser->setDescription("Nullam quiris risus eget urna mollis ornare vel eu leo. Soccis natoque penatibus et magnis dis parturient montes. Soccis natoque penatibus et magnis dis parturient montes.");
            $teaser->setContext("primary");
            $teaser->setHorizontal(true);
            $teaser->setHeaderContext("danger");
//            $counter->setFeatured(Counter::FEATURED_NONE);



            $userManager = $this->get("uneak.user_manager");
            $user = $userManager->findUserBy(array("username" => "admin"));
            $userBadge = new UserBadge($user);

//            $counter->setFeatured(Counter::FEATURED_NONE);


//            $body->addBlock($userBadge);
//            $body->addBlock($teaser);
//            $body->addBlock($counter);
//            $body->addBlock($accordion);
//            $body->addBlock($tabs);
//            $body->addBlock($panel);


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
            $widgetStats = new WidgetStats();
            $widgetStats->addProgress(new ProgressBar("title", "25%", 25));
            $widgetStats->addProgress(new ProgressBar("title", "35%", 35));
            $widgetStats->addProgress(new ProgressBar("title", "10 ventes", 68));

            $entityLayout->getEntitySidebar()->addWidget("stats", $widgetStats);


            $widgetStatus = new WidgetStatus();
            $widgetStatus->addStatus("title 1", "#", WidgetStatus::COLOR_GREEN);
            $widgetStatus->addStatus("title 2", "#", WidgetStatus::COLOR_ORANGE);
            $widgetStatus->addStatus("title RAID", "#", WidgetStatus::COLOR_RED);

            $entityLayout->getEntitySidebar()->addWidget("status", $widgetStatus);
            $layoutSideBar->addWidget("status", $widgetStatus);


//
//            $layoutLeftSidebar->addWidget("stats", $widgetWrapper);



            return $blockBuilder->render("layout");
//			return $this->render('{{ renderBlock("layout") }}');



		}


	}
