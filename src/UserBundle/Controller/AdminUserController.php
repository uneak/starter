<?php

	namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    use Uneak\PortoAdminBundle\Blocks\Content\Content;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContentScroll;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\PortoAdminBundle\Blocks\UIElements\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Controller\LayoutController;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;
    use UserBundle\Entity\User;
    use UserBundle\Form\UserType;

    class AdminUserController extends LayoutEntityController {

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






//            $layoutLeftSideBar = $this->layout->getLeftSideBar();
//            $layoutContentBody = $this->layout->getContent()->getBody();


//            $entitySidebar = $this->entityLayout->getEntitySidebar();
//            $entityLayoutContent = $this->entityLayout->getContent();
//            $entityLayoutContentHeader = $entityLayoutContent->getHeader();



//            $widgetStats = new WidgetStats();
//            $widgetStats->addProgress(new ProgressBar("title", "25%", 25));
//            $widgetStats->addProgress(new ProgressBar("title", "35%", 35));
//            $widgetStats->addProgress(new ProgressBar("title", "10 ventes", 68));
//
//            $this->entityLayoutSidebar->addWidget("stats", $widgetStats);
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

            $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);




            $user = new User();

            $form = $this->createForm(new UserType(), $user);
            $form->add('submit', 'submit', array('label' => 'Creer'));

            if ($request->getMethod() == 'POST') {

//                $flash = $this->get('braincrafted_bootstrap.flash');
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $userManager = $this->get('fos_user.user_manager');
                    $userManager->updateUser($user);

                    return $this->redirect($route->getChild('*/subject/show', array('user' => $user->getId()))->getRoutePath());
                } else {
//                    $flash->error('Votre formulaire est invalide.');
                }
            }


            $formManager = $this->get("uneak.formsmanager");

            $formBlock = new Form($formManager->createView($form));


            $panel = new Panel();
            $panel->setTitle($route->getMetaData('_label'));
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $this->entityLayoutContentBody->addBlock($panel, 'form');

//            $this->layout->setLeftSidebarCollapsed(true);
//            $layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);

//            $layoutLeftSideBar = $this->layout->getLeftSideBar();
//            $layoutContentBody = $this->layout->getContent()->getBody();
//            $layoutContentHeaderBreadcrumb = $this->layout->getContent()->getHeader()->getBreadcrumb();
//            $layoutContentHeaderBreadcrumb->setFlattenRoute($route);
//
//            $entityLayout = new Entity();
//            $layoutContentBody->addBlock($entityLayout);
//            $entitySidebar = $entityLayout->getEntitySidebar();
//
//            $entityLayoutContent = new EntityContentScroll();
//            $entityLayout->setContent($entityLayoutContent);
//
//
//            $menuHelper = $this->get("uneak.routesmanager.menu.helper");
//            $fRouteManager = $this->get("uneak.routesmanager.flattenmanager");
//
//            $flattenCrud = $fRouteManager->getFlattenRoute('user');
//            $menu = new Menu($menuHelper->createMenu($flattenCrud->getMetaData('_menu'), $flattenCrud));
//            $entitySidebar->addWidget("menu", $menu, false, 9999);
//
//            $entityLayoutContent->setTitle($flattenCrud->getMetaData('_label'));
//            $entityLayoutContent->setSubtitle('From <a href="#">Okler Themes</a> to <a href="#">You</a>, started on July, 05, 2014');




//            return $this->blockBuilder->render("layout");
        }




        public function indexGridAction( FlattenRoute $route, Request $request) {

            $gridHelper = $this->get("uneak.routesmanager.grid.helper");
            $menuHelper = $this->get("uneak.routesmanager.menu.helper");

            $params = $request->query->all();
            $gridData = $gridHelper->gridFields($gridHelper->createGridQueryBuilder('UserBundle\Entity\User', $params), $params);
            $recordsTotal = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder('UserBundle\Entity\User', $params));
            $recordsFiltered = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder('UserBundle\Entity\User', $params));



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
                $menu->setTemplateAlias("block_template_entity_content_header_menu");

                $rowActions = $route->getParent()->getNestedRoute()->getRowActions();
                $root = $menuHelper->createMenu($rowActions, $route, array('user' => $row['DT_RowId']));
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
