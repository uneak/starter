<?php

	namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContentScroll;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;

	class AdminClientController extends Controller {

        protected $blockBuilder;
        protected $layout;


        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->blockBuilder = $this->get("uneak.blocksmanager.builder");
            $this->blockBuilder->addBlock("layout", "block_main_interface");
            $this->layout = $this->blockBuilder->getBlock("layout");

//            $this->layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $this->layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $this->layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $this->layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);
        }

        
        public function indexAction(FlattenRoute $route, Request $request)
        {

            $this->layout->setLeftSidebarCollapsed(true);


            $layoutLeftSideBar = $this->layout->getLeftSideBar();
            $layoutContentBody = $this->layout->getContent()->getBody();
            $layoutContentHeaderBreadcrumb = $this->layout->getContent()->getHeader()->getBreadcrumb();
            $layoutContentHeaderBreadcrumb->setFlattenRoute($route);

            $entityLayout = new Entity();
            $layoutContentBody->addBlock($entityLayout);
            $entitySidebar = $entityLayout->getEntitySidebar();
            $entityLayoutContent = $entityLayout->getContent();
            $entityLayoutContentHeader = $entityLayoutContent->getHeader();


            $blockManager = $this->get("uneak.blocksmanager.blocks");
            $menu = $blockManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);
            $entitySidebar->addWidget("menu", $menu, false, 999999);
            $entityLayoutContentHeader->setTitle($route->getMetaData('_label'));


//            $widgetStats = new WidgetStats();
//            $widgetStats->addProgress(new ProgressBar("title", "25%", 25));
//            $widgetStats->addProgress(new ProgressBar("title", "35%", 35));
//            $widgetStats->addProgress(new ProgressBar("title", "10 ventes", 68));
//
//            $entityLayout->getEntitySidebar()->addWidget("stats", $widgetStats);
//
//
//            $widgetStatus = new WidgetStatus();
//            $widgetStatus->addStatus("title 1", "#", WidgetStatus::COLOR_GREEN);
//            $widgetStatus->addStatus("title 2", "#", WidgetStatus::COLOR_ORANGE);
//            $widgetStatus->addStatus("title RAID", "#", WidgetStatus::COLOR_RED);
//
//            $entityLayout->getEntitySidebar()->addWidget("status", $widgetStatus);
//            $layoutLeftSideBar->addWidget("status", $widgetStatus);


            return $this->blockBuilder->render("layout");
        }


        public function newAction(FlattenRoute $route, Request $request)
        {

            $this->layout->setLeftSidebarCollapsed(true);
//            $layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);

            $layoutLeftSideBar = $this->layout->getLeftSideBar();
            $layoutContentBody = $this->layout->getContent()->getBody();
            $layoutContentHeaderBreadcrumb = $this->layout->getContent()->getHeader()->getBreadcrumb();
            $layoutContentHeaderBreadcrumb->setFlattenRoute($route);

            $entityLayout = new Entity();
            $layoutContentBody->addBlock($entityLayout);
            $entitySidebar = $entityLayout->getEntitySidebar();

            $entityLayoutContent = new EntityContentScroll();
            $entityLayout->setContent($entityLayoutContent);


            $menuHelper = $this->get("uneak.routesmanager.menu.helper");
            $fRouteManager = $this->get("uneak.routesmanager.flattenmanager");

            $flattenCrud = $fRouteManager->getFlattenRoute('user');
            $menu = new Menu($menuHelper->createMenu($flattenCrud->getMetaData('_menu'), $flattenCrud));
            $entitySidebar->addWidget("menu", $menu, false, 9999);

            $entityLayoutContent->setTitle($flattenCrud->getMetaData('_label'));
            $entityLayoutContent->setSubtitle('From <a href="#">Okler Themes</a> to <a href="#">You</a>, started on July, 05, 2014');




            return $this->blockBuilder->render("layout");
        }


	}
