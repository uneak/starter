<?php

namespace ProspectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;

use Uneak\FieldSearchBundle\Field\SearchType\SearchType;
use Uneak\FieldSearchBundle\Form\FieldSearchType;
use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
use Uneak\PortoAdminBundle\Blocks\Form\Form;
use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\PortoAdminBundle\PNotify\PNotify;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class ProspectAdminController extends LayoutEntityController
{


    public function indexAction(FlattenRoute $route, Request $request)
    {

        $blockBuilder = $this->get("uneak.blocksmanager.builder");
        $blockBuilder->addBlock("layout", "block_main_interface");

        $layout = $this->get("uneak.admin.page.entity.layout");
        $layout->setLayout($blockBuilder->getBlock("layout"));
        $layout->buildEntityLayout($route);
        $layout->buildGridPage($route);

        $gridNested = $route->getNestedRoute();
        $crudHandler = $route->getHandler();




        $query = array();
        $selectQuery = array();
        $fieldColumns = $crudHandler->getColumns($route);
        $columns = array_merge($gridNested->getColumns(), $fieldColumns);

        foreach ($columns as $column) {
            $selectQuery[] = $column['name'];
        }
        $query['fields'] = join(',', $selectQuery);


        $form = $this->createForm(new FieldSearchType($fieldColumns));
        $form->add('submit', 'submit', array('label' => 'Filtrer'));


        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                foreach ($form as $key => $child) {
                    $type = $child->getConfig()->getType()->getInnerType();
                    if ($type instanceof SearchType) {
                        $data = $child->getData();
                        if ($data['enabled'] == true) {
                            $type::buildQuery($query, $key, $data);
                        }
                    }
                }


            } else {
                $this->addFlash('error', new PNotify(array(
                    'type' => 'error',
                    'title' => 'Formulaire',
                    'text' => 'Votre formulaire est invalide.',
                    'shadow' => true,
                    'stack' => 'stack-bar-bottom'
                )));
            }
        }

        $formsManager = $this->get('uneak.formsmanager');
        $formView = $formsManager->createView($form);


        $formBlock = new Form($formView);
        $formBlock->addClass("form-horizontal");
        $formBlock->addClass("form-bordered");

        $panel = new Panel();
        $panel->setTitle("Filtres");
        $panel->setCollapsed(($request->getMethod() != Request::METHOD_POST));
        $panel->setDismiss(true);
        $panel->setToggle(true);
        $panel->addBlock($formBlock);

        $layout->getSubLayoutContentBody()->addBlock($panel, 'filter');



        $datatable = new Datatable();
        $datatable->setAjax($route->getChild('_grid')->getRoutePath());
        if (count($query)) {
            $datatable->setQuery($query);
        }
        $datatable->setColumns($columns);

        $layout->getSubLayoutContentBody()->addBlock($datatable, 'datatable');


        return $blockBuilder->renderResponse("layout");
    }





}