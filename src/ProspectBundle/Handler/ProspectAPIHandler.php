<?php

namespace ProspectBundle\Handler;


use FieldBundle\Admin\Field;
use Symfony\Component\HttpFoundation\Request;
use Uneak\FieldGroupBundle\Group\FieldGroupsHelper;
use Uneak\FieldSearchBundle\Field\FieldSearchManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;
use Uneak\ProspectBundle\Prospect\ProspectsManager;

class ProspectAPIHandler extends EntityAPIHandler {


    /**
     * @var ProspectsManager
     */
    protected $prospectsManager;
    /**
     * @var FieldGroupsHelper
     */
    private $fieldGroupsHelper;
    /**
     * @var FieldSearchManager
     */
    private $fieldSearchManager;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, ProspectsManager $prospectsManager, FieldGroupsHelper $fieldGroupsHelper, FieldSearchManager $fieldSearchManager)
    {
        parent::__construct($formFactory, $em);
        $this->prospectsManager = $prospectsManager;
        $this->fieldGroupsHelper = $fieldGroupsHelper;
        $this->fieldSearchManager = $fieldSearchManager;
    }


    public function getProspectsFieldsByGroup($group = null) {
        $dbFields = $this->prospectsManager->findProspectsFieldsByGroup($group);
        $fields = array();
        /** @var $dbField Field */
        foreach ($dbFields as $dbField) {
            $fields[] = array(
                'title' => $dbField->getLabel(),
                'name' => $dbField->getSlug(),
                'fieldsearch' => $this->fieldSearchManager->getFieldSearchsByFieldData($dbField->getType()),
            );

        }

        return $fields;
    }


    public function getForm($formType, $entity, $method = Request::METHOD_PUT) {
        return $this->fieldGroupsHelper->createForm($formType, $entity, $method);
    }


    public function createEntity() {
        return $this->prospectsManager->createProspect();
    }

    public function get($id) {
        $entity = $this->prospectsManager->findProspectById($id);
        if (!$entity) {
            throw new NotFoundException($this->entityClass." $id not found", $id);
        }
        return $entity;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->prospectsManager->removeProspect($entity);
    }


    public function all(array $criteria) {
        return $this->prospectsManager->getAll($criteria);
    }

    public function count(array $criteria = null) {
        return $this->prospectsManager->getCount($criteria);
    }





    public function persistEntity(FormInterface $form) {
        $formProspect = $form->get('o_prospect')->getData();
        $prospect = $this->prospectsManager->findProspectById($formProspect);
        if (!$prospect) {
            $gslug = $form->get('o_group')->getData();
            $prospect = $this->prospectsManager->createProspect($gslug);
//            $prospect = $this->prospectsManager->createProspect();
        }

        $data = $form->getData();
        foreach ($data as $key => $value) {
            $this->prospectsManager->setField($prospect, $key, $value);
        }

        $this->prospectsManager->saveProspect($prospect);
        return $prospect;
    }
}