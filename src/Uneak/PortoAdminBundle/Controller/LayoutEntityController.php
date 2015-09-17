<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class LayoutEntityController extends LayoutController {

        protected $entityLayout;

        public function setRoute(FlattenRoute $route) {

            $layoutContentHeaderBreadcrumb = $this->layout->getContent()->getHeader()->getBreadcrumb();
            $layoutContentHeaderBreadcrumb->setFlattenRoute($route);

            $blockManager = $this->get("uneak.blocksmanager.blocks");
            $menu = $blockManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);

            $entitySidebar = $this->entityLayout->getEntitySidebar();
            $entitySidebar->addWidget("menu", $menu, false, 999999);

            $entityLayoutContentHeader = $this->entityLayout->getContent()->getHeader();
            $entityLayoutContentHeader->setTitle($route->getMetaData('_label'));


        }


        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->layout->setLeftSidebarCollapsed(true);

            $layoutContentBody = $this->layout->getContent()->getBody();
            $this->entityLayout = new Entity();
            $layoutContentBody->addBlock($this->entityLayout);

        }



	}
