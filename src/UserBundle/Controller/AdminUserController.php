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
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\PortoAdminBundle\Blocks\UIElements\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Controller\LayoutController;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
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

        }

        public function showAction(FlattenRoute $route, Request $request)
        {
            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            $entity = $entityRoute->getParameterSubject();


        }


        public function editAction(FlattenRoute $route, Request $request)
        {

            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            $entity = $entityRoute->getParameterSubject();
            $formType = $route->getFormType();

            $form = $this->createForm($formType, $entity);
            $form->add('submit', 'submit', array('label' => 'Modifier'));

            if ($request->getMethod() == 'POST') {

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $userManager = $this->get('fos_user.user_manager');
                    $userManager->updateUser($entity);

                    return $this->redirect($entityRoute->getChild('show')->getRoutePath());
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

                    $userManager = $this->get('fos_user.user_manager');
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
