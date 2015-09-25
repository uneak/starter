<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class LayoutEntityController extends LayoutMainInterfaceController {

        protected $entity = null;
        protected $entityRoute = null;
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


            $this->entityRoute = $route;
            while($this->entityRoute && !$this->entityRoute instanceof FlattenEntityRoute) {
                $this->entityRoute = $this->entityRoute->getParent();
            }

            if ($this->entityRoute) {
                $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);
                $this->entity = $this->entityRoute->getParameterSubject();

                $label = $twig->createTemplate($route->getMetaData('_label'))->render(array('entity' => $this->entity));
                $description = $twig->createTemplate($route->getMetaData('_description'))->render(array('entity' => $this->entity));

                $this->entityLayoutContent->setTitle($label);
                $this->entityLayoutContent->setSubtitle($description);


                $vichHelper = $this->get("vich_uploader.templating.helper.uploader_helper");
                $photoFile = $vichHelper->asset($this->entity, $route->getMetaData('_image'));

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


        public function indexAction(FlattenRoute $route, Request $request)
        {
            $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_FIXED);

            $search = new Search();
            $search->setInputName("datatable_search");
            $this->entityLayoutContent->addWidget("search", $search);

            $menuHelper = $this->get("uneak.routesmanager.menu.helper");

            $factory = $menuHelper->getFactory();
            $root = $factory->createItem('root');

            $tableShow = $factory->createItem('table_show', array(
                'label' => 'Afficher',
                'icon' => 'chevron-down',
            ));
            $root->addChild($tableShow);
            $showRow = array("100", "50", "25", "10");
            foreach ($showRow as $rowNumber) {
                $tableShow->addChild($factory->createItem('row_show_'.$rowNumber, array(
                    'label' => 'afficher '.$rowNumber.' éléments',
                    'linkAttributes' => array(
                        'class' => 'table-row-number',
                        'data-value' => $rowNumber,
                    )
                )));
            }

            $this->entityLayoutContentActions->setRoot($root);

            $gridNested = $route->getNestedRoute();
            $datatable = new Datatable();
            $datatable->setSearchInput('#'.$search->getInputName());
            $datatable->setAjax($route->getChild('_grid')->getRoutePath());
            $datatable->setColumns($gridNested->getColumns());

            $this->entityLayoutContentBody->addBlock($datatable, 'datatable');

        }

        public function showAction(FlattenRoute $route, Request $request)
        {
            $this->entity;


        }


        public function editAction(FlattenRoute $route, Request $request)
        {

            $formType = $route->getFormType();

            $form = $this->createForm($formType, $this->entity);
            $form->add('submit', 'submit', array('label' => 'Modifier'));

            if ($request->getMethod() == 'POST') {

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $userManager = $this->get('uneak.user_manager');
                    $userManager->updateUser($this->entity);

                    return $this->redirect($this->entityRoute->getChild('show')->getRoutePath());
                } else {
                    $this->addFlash('error', 'Votre formulaire est invalide.');
                }
            }



            $formBlock = new Form($form);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle($route->getMetaData('_label'));
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $this->entityLayoutContentBody->addBlock($panel, 'form');


        }


        public function newAction(FlattenRoute $route, Request $request)
        {

            $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);

            $entityClass = $route->getCRUD()->getEntity();
            $formType = $route->getFormType();

            $entity = new $entityClass();

            $form = $this->createForm($formType, $entity);
            $form->add('submit', 'submit', array('label' => 'Valider'));

            if ($request->getMethod() == 'POST') {

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $userManager = $this->get('uneak.user_manager');
                    $userManager->updateUser($entity);

                    return $this->redirect($route->getChild('*/subject/show', array($entity->getId()) )->getRoutePath());
                } else {
                    $this->addFlash('error', 'Votre formulaire est invalide.');
                }
            }


            $formBlock = new Form($form);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle($route->getMetaData('_label'));
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $this->entityLayoutContentBody->addBlock($panel, 'form');

        }




        public function indexGridAction(FlattenRoute $route, Request $request) {

            $entityClass = $route->getCRUD()->getEntity();

            $gridHelper = $this->get("uneak.routesmanager.grid.helper");
            $menuHelper = $this->get("uneak.routesmanager.menu.helper");

            $params = $request->query->all();
            $gridData = $gridHelper->gridFields($gridHelper->createGridQueryBuilder($entityClass, $params), $params);
            $recordsTotal = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder($entityClass, $params));
            $recordsFiltered = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder($entityClass, $params));



            $data = array();
            foreach ($gridData as $object) {
                $row = array();
                foreach ($params['columns'] as $columns) {
                    if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {
                        $value = $object[str_replace(".", "_", $columns['name'])];
                        if ($value instanceof \DateTime) {
                            $value = $value->format('d/m/Y H:m:s');
                        }
                        $row[$columns['data']] = $value;
                    } else {
                        $row[$columns['data']] = "";
                    }
                }
                $row['DT_RowId'] = $object['DT_RowId'];



                $menu = new Menu();
                $menu->setTemplateAlias("block_template_grid_actions_menu");

                $rowActions = $route->getParent()->getNestedRoute()->getRowActions();
                $root = $menuHelper->createMenu($rowActions, $route, array($row['DT_RowId']));
                $menu->setRoot($root);

                $this->blockBuilder->addBlock("row_actions", $menu);
                $row['_actions'] = $this->renderView("<div class='menu-bullets'>{{ renderBlock('row_actions') }}</div>");


                array_push($data, $row);
            }


            return new JsonResponse(array(
                'draw'            => $params["draw"],
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ));
        }
	}
