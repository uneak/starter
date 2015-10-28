<?php

namespace Uneak\PortoAdminBundle\Handler;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
use Uneak\PortoAdminBundle\LayoutBuilder\AdminPageSubLayoutBuilder;
use Uneak\RoutesManagerBundle\Helper\GridHelper;
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
        $entity = ($entityRoute) ? $entityRoute->getParameterSubject() : null;
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

    public function getDatatableArray($entityClass, array $params, GridHelper $gridHelper) {

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

            array_push($data, $row);
        }

        return array(
            'draw'            => $params["draw"],
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        );
    }

}