<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class LayoutEntityController extends LayoutController {

        protected $entityLayout;
        protected $entityLayoutContent;
        protected $entityLayoutContentBody;
        protected $entityLayoutSidebar;
        protected $entityLayoutToolbar;
        protected $entityLayoutContentActions;

        public function setRoute(FlattenRoute $route) {

            $twig = new \Twig_Environment(new \Twig_Loader_Array(array()));

            $this->breadcrumb->setFlattenRoute($route);

            $blockManager = $this->get("uneak.blocksmanager.blocks");
            $menu = $blockManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);
            $this->entityLayoutSidebar->addWidget("menu", $menu, false, 999999);

            $this->layoutContentHeader->setTitle($route->getMetaData('_label'));

            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            if ($entityRoute) {
                $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);
                $entity = $entityRoute->getParameterSubject();

                $label = $twig->createTemplate($route->getMetaData('_label'))->render(array('entity' => $entity));
                $description = $twig->createTemplate($route->getMetaData('_description'))->render(array('entity' => $entity));

                $this->entityLayoutContent->setTitle($label);
                $this->entityLayoutContent->setSubtitle($description);


                $vichHelper = $this->get("vich_uploader.templating.helper.uploader_helper");
                $photoFile = $vichHelper->asset($entity, $route->getMetaData('_image'));

                if ($photoFile) {
                    $photo = new Photo();
                    $photo->setPhoto($photoFile);
                    $this->entityLayoutSidebar->addWidget("photo", $photo, false, 9999999);
                }




            } else {

                $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_FIXED);
                $this->entityLayoutContent->setTitle($route->getMetaData('_label'));
                $this->entityLayoutContent->setSubtitle($route->getMetaData('_description'));
            }


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
