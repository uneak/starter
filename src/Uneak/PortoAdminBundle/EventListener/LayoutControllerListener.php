<?php

namespace Uneak\PortoAdminBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\User\UserInterface;
use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
use Uneak\PortoAdminBundle\Controller\LayoutController;
use Uneak\PortoAdminBundle\Controller\LayoutControllerInterface;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\PortoAdminBundle\Controller\LayoutMainInterfaceController;
use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
use UserBundle\Controller\LayoutProfileController;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class LayoutControllerListener {

    private $controller = null;
    private $router;
    /**
     * @var \Uneak\BlocksManagerBundle\Blocks\BlockBuilder
     */
    private $blockBuilder;
    /**
     * @var \Uneak\BlocksManagerBundle\Blocks\BlocksManager
     */
    private $blocksManager;
    /**
     * @var \Vich\UploaderBundle\Templating\Helper\UploaderHelper
     */
    private $uploaderHelper;

    public function __construct(Router $router, BlockBuilder $blockBuilder, BlocksManager $blocksManager, UploaderHelper $uploaderHelper) {
        $this->router = $router;
        $this->blockBuilder = $blockBuilder;
        $this->blocksManager = $blocksManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function onKernelController(FilterControllerEvent $event) {

        $controller = $event->getController();
        $this->controller = $controller[0];

        if ($this->controller instanceof LayoutMainInterfaceController) {

            $this->blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->blockBuilder->getBlock("layout");
            $layoutHeader = $layout->getHeader();
            $layoutContent = $layout->getContent();
            $layoutContentBody = $layoutContent->getBody();
            $layoutContentHeader = $layoutContent->getHeader();
            $breadcrumb = $layoutContentHeader->getBreadcrumb();
            $layoutLeftSidebar = $layout->getLeftSidebar();
            $layoutRightSidebar = $layout->getRightSidebar();


            //            $this->layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
            //            $this->layout->setBackgroundColor(MainInterface::COLOR_DARK);
            //            $this->layout->setHeaderColor(MainInterface::COLOR_DARK);
            //            $this->layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);


            $this->controller->setBlockBuilder($this->blockBuilder);
            $this->controller->setLayout($layout);
            $this->controller->setLayoutHeader($layoutHeader);
            $this->controller->setLayoutContent($layoutContent);
            $this->controller->setLayoutContentBody($layoutContentBody);
            $this->controller->setLayoutContentHeader($layoutContentHeader);
            $this->controller->setBreadcrumb($breadcrumb);
            $this->controller->setLayoutLeftSidebar($layoutLeftSidebar);
            $this->controller->setLayoutRightSidebar($layoutRightSidebar);



            if ($this->controller instanceof LayoutEntityController) {


                $layout->setLeftSidebarCollapsed(true);


                $entityLayout = new Entity();
                $entityLayoutContent = $entityLayout->getContent();
                $entityLayoutContentBody = $entityLayoutContent->getBody();
                $entityLayoutContentActions = $entityLayoutContent->getActions();
                $entityLayoutSidebar = $entityLayout->getEntitySidebar();
                $entityLayoutToolbar = $entityLayout->getToolbar();

                $layoutContentBody->addBlock($entityLayout);


                $this->controller->setEntityLayout($entityLayout);
                $this->controller->setEntityLayoutContent($entityLayoutContent);
                $this->controller->setEntityLayoutContentBody($entityLayoutContentBody);
                $this->controller->setEntityLayoutContentActions($entityLayoutContentActions);
                $this->controller->setEntityLayoutSidebar($entityLayoutSidebar);
                $this->controller->setEntityLayoutToolbar($entityLayoutToolbar);




                if ($this->controller instanceof LayoutProfileController) {


                    $menu = new Menu($this->blocksManager->getBlock("block_user_menu")->getRoot());
                    $entityLayoutSidebar->addWidget("menu", $menu, false, 999999);


                    $layoutContentHeader->setTitle("Profile");


                    $entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);

                    $entity = $this->controller->getUser();
                    if (!is_object($entity) || !$entity instanceof UserInterface) {
                        throw new AccessDeniedException('This user does not have access to this section.');
                    }

                    $entityLayoutContent->setTitle("Profile");
                    $entityLayoutContent->setSubtitle($entity->getFirstName()." ".$entity->getLastName());

                    $photoFile = $this->uploaderHelper->asset($entity, "imageFile");

                    if ($photoFile) {
                        $photo = new Photo();
                        $photo->setPhoto($photoFile);
                        $entityLayoutSidebar->addWidget("photo", $photo, false, 9999999);
                    }

                }



                $request = $event->getRequest();
                $routeCollection = $this->router->getRouteCollection();
                $route = $routeCollection->get($request->attributes->get('_route'));

                if ($route instanceof FlattenRoute) {

                    $twig = new \Twig_Environment(new \Twig_Loader_Array(array()));

                    $breadcrumb->setFlattenRoute($route);

                    $menu = $this->blocksManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);
                    $entityLayoutSidebar->addWidget("menu", $menu, false, 999999);


                    $layoutContentHeader->setTitle($route->getMetaData('_label'));


                    $entityRoute = $route;
                    while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                        $entityRoute = $entityRoute->getParent();
                    }

                    if ($entityRoute) {
                        $this->controller->setEntityRoute($entityRoute);

                        $entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);
                        $entity = $entityRoute->getParameterSubject();
                        $this->controller->setEntity($entity);

                        $label = $twig->createTemplate($route->getMetaData('_label'))->render(array('entity' => $entity));
                        $description = $twig->createTemplate($route->getMetaData('_description'))->render(array('entity' => $entity));

                        $entityLayoutContent->setTitle($label);
                        $entityLayoutContent->setSubtitle($description);

                        $photoFile = $this->uploaderHelper->asset($entity, $route->getMetaData('_image'));

                        if ($photoFile) {
                            $photo = new Photo();
                            $photo->setPhoto($photoFile);
                            $entityLayoutSidebar->addWidget("photo", $photo, false, 9999999);
                        }

                    } else {

                        $entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_FIXED);
                        $entityLayoutContent->setTitle($route->getMetaData('_label'));
                        $entityLayoutContent->setSubtitle($route->getMetaData('_description'));
                    }

                }

            }
        }

    }


    public function onKernelView(GetResponseForControllerResultEvent $event) {

        if ($this->controller instanceof LayoutControllerInterface) {

            $result = $event->getControllerResult();
            $parameters = (is_array($result)) ? $result : array();

            $event->setResponse($this->controller->render('{{ renderBlock("layout") }}', $parameters));

        }
    }


}
