<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class LayoutEntityController extends LayoutController {

        protected $entityLayout;
        protected $entityLayoutContent;
        protected $entityLayoutContentBody;
        protected $entityLayoutSidebar;
        protected $entityLayoutToolbar;
        protected $entityLayoutContentActions;

        public function setRoute(FlattenRoute $route) {

            $crudRoute = $route->getCRUD();

//            $this->breadcrumb->setFlattenRoute($route);

            $blockManager = $this->get("uneak.blocksmanager.blocks");
            $menu = $blockManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);
            $this->entityLayoutSidebar->addWidget("menu", $menu, false, 999999);

//            $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);
            $this->entityLayoutContent->setTitle($crudRoute->getMetaData('_label'));
            $this->entityLayoutContent->setSubtitle($route->getMetaData('_label'));

        }


        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->layout->setLeftSidebarCollapsed(true);

            $this->layoutHeader = $this->layout->getHeader();
            $this->layoutContent = $this->layout->getContent();
            $this->layoutContentBody = $this->layoutContent->getBody();
            $this->layoutContentHeader = $this->layoutContent->getHeader();
            $this->layoutLeftSidebar = $this->layout->getLeftSidebar();
            $this->layoutRightSidebar = $this->layout->getRightSidebar();

            $this->entityLayout = new Entity();
            $this->entityLayoutContent = $this->entityLayout->getContent();
            $this->entityLayoutContentBody = $this->entityLayoutContent->getBody();
            $this->entityLayoutContentActions = $this->entityLayoutContent->getActions();
            $this->entityLayoutSidebar = $this->entityLayout->getEntitySidebar();
            $this->entityLayoutToolbar = $this->entityLayout->getToolbar();


            $this->layoutContentBody->addBlock($this->entityLayout);

        }



	}
