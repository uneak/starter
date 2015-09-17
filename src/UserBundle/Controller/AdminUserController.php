<?php

	namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\Request;

    use Uneak\PortoAdminBundle\Blocks\Content\Content;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContentScroll;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Tabs\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Controller\LayoutController;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;

	class AdminUserController extends LayoutEntityController {

        public function indexAction(FlattenRoute $route, Request $request)
        {
            $content = $this->entityLayout->getContent()->getBody();


            $tabs = new Tabs();
            $tabs->setContext("primary");
            $tabs->setRight(false);
            $tabs->setBottom(false);
            $tabs->setJustified(false);
            $tabs->setVertical(false);

            $tabs->addTab('user', 'Utilisateur', new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $tabs->addTab(null, 'Deux', new Content("Hello<br/><img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));
            $tabs->addTab('user', 'Trois', new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"));


//            $content->addBlock(new Content("<img src='http://dev.starter.com/uploads/cache/porto_admin_brand_photo/bundles/uneakportoadmin/images/volkswagen_logo.jpg' />"), 'tab');
            $content->addBlock($tabs, 'tab');

//            $layoutLeftSideBar = $this->layout->getLeftSideBar();
//            $layoutContentBody = $this->layout->getContent()->getBody();


//            $layoutContentHeaderBreadcrumb = $this->layout->getContent()->getHeader()->getBreadcrumb();
//            $layoutContentHeaderBreadcrumb->setFlattenRoute($route);
//
//
//            $entitySidebar = $this->entityLayout->getEntitySidebar();
//            $entityLayoutContent = $this->entityLayout->getContent();
//            $entityLayoutContentHeader = $entityLayoutContent->getHeader();
//
//
//            $blockManager = $this->get("uneak.blocksmanager.blocks");
//            $menu = $blockManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);
//            $entitySidebar->addWidget("menu", $menu, false, 999999);
//            $entityLayoutContentHeader->setTitle($route->getMetaData('_label'));


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


//            return $this->blockBuilder->render("layout");


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




//            return $this->blockBuilder->render("layout");
        }


	}
