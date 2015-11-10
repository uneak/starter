<?php

namespace Uneak\PortoAdminBundle\Handler;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
use Uneak\PortoAdminBundle\LayoutBuilder\AdminPageSubLayoutBuilder;
use Uneak\RoutesManagerBundle\Helper\GridHelper;
use Uneak\RoutesManagerBundle\Helper\MenuHelper;
use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class CRUDHandler implements CRUDHandlerInterface {

    /**
     * @var APIHandlerInterface
     */
    protected $apiHandler;

    public function __construct(APIHandlerInterface $apiHandler) {
        $this->apiHandler = $apiHandler;
    }



    /**
     * @param FlattenRoute $route
     * @param string $method
     * @return FormInterface
     */
    public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {
        $entityRoute = $route;
        while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
            $entityRoute = $entityRoute->getParent();
        }
        $entity = ($entityRoute) ? $entityRoute->getParameterSubject() : $this->createEntity();
        $formType = $route->getFormType();

        return $this->apiHandler->getForm($formType, $entity, $method);
    }

    public function createEntity() {
        return $this->apiHandler->createEntity();
    }

    public function deleteEntity(FormInterface $form, $entity) {
        return $this->apiHandler->delete($entity->getId());
    }

    public function persistEntity(FormInterface $form) {
        return $this->apiHandler->persistEntity($form);
    }

    public function submitForm(FormInterface $form, array $parameters) {
        return $this->apiHandler->submitForm($form, $parameters);
    }

    public function processForm(FormInterface $form, array $parameters) {
        return $this->apiHandler->processForm($form, $parameters);
    }

    public function getDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {

        $nestedGridRoute = $route->getParent()->getNestedRoute();
        $ids = $nestedGridRoute->getIds();
        $entityClass = $route->getCRUD()->getEntity();

        $gridData = $gridHelper->gridFields($gridHelper->createGridQueryBuilder($entityClass, $params), $params, $ids);
        $recordsTotal = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder($entityClass, $params));
        $recordsFiltered = $gridHelper->gridFieldsCount($gridHelper->createGridQueryBuilder($entityClass, $params));

        $gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

        return array_merge($gridDataArray, array(
            'draw'            => $params["draw"],
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ));
    }


    public function getGridDataArray($gridData, array $ids, array $columns) {

        $data = array();
        $id = array();
        foreach ($gridData as $object) {
            $row = array();
            foreach ($ids as $key => $path) {
                $row[$key] = $object['idkey_' . $key];
            }
            array_push($id, $row);
            $row = array();
            foreach ($columns as $column) {
                if ($column['name'] && substr($column['name'], 0, 1) != '_') {
                    $value = $object[str_replace(".", "_", $column['name'])];
                    if ($value instanceof \DateTime) {
                        $value = $value->format('d/m/Y H:m:s');
                    }
                    $row[$column['data']] = $value;
                } else {
                    $row[$column['data']] = "";
                }
            }
            array_push($data, $row);
        }

        return array(
            'data'            => $data,
            'id'              => $id,
        );

    }


    public function addDatatableArrayActions(array &$datatableArray, FlattenRoute $route, MenuHelper $menuHelper, BlockBuilder $blockBuilder) {

        $nestedGridRoute = $route->getParent()->getNestedRoute();
        $rowActions = $nestedGridRoute->getRowActions();

        for($i = 0; $i < count($datatableArray['data']); $i++) {
            $menu = new Menu();
            $menu->setTemplateAlias("block_template_grid_actions_menu");
            $root = $menuHelper->createMenu($rowActions, $route, $datatableArray['id'][$i]);
            $menu->setRoot($root);
            $blockBuilder->addBlock("row_actions", $menu);
            $datatableArray['data'][$i]['_actions'] = "<div class='menu-bullets'>".$blockBuilder->render('row_actions')."</div>";
        }

    }



}