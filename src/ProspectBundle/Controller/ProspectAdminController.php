<?php

	namespace ProspectBundle\Controller;

    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

    class ProspectAdminController extends LayoutEntityController {


        public function indexAction(FlattenRoute $route) {
            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);
            $layout->buildGridPage($route);

            $gridNested = $route->getNestedRoute();
            $crudHandler = $route->getHandler();

            $columns = array_merge($gridNested->getColumns(), $crudHandler->getColumns($route));

            $datatable = new Datatable();
            $datatable->setAjax($route->getChild('_grid')->getRoutePath());
            $datatable->setColumns($columns);

            $layout->getSubLayoutContentBody()->addBlock($datatable, 'datatable');


            return $blockBuilder->renderResponse("layout");
        }


	}
