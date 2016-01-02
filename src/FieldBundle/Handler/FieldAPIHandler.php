<?php

namespace FieldBundle\Handler;


use Symfony\Component\HttpFoundation\Request;
use Uneak\FieldBundle\Entity\Field;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\FieldBundle\Field\FieldsHelper;
use Uneak\FieldTypeBundle\Field\FieldTypesHelper;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\AbstractAPIHandler;
use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;

class FieldAPIHandler extends AbstractAPIHandler implements APIHandlerInterface {


    /**
     * @var FieldsHelper
     */
    private $fieldsHelper;
    /**
     * @var FieldTypesHelper
     */
    private $fieldTypesHelper;


    public function __construct(FormFactoryInterface $formFactory, FieldsHelper $fieldsHelper, FieldTypesHelper $fieldTypesHelper) {
        parent::__construct($formFactory);
        $this->fieldsHelper = $fieldsHelper;
        $this->fieldTypesHelper = $fieldTypesHelper;
    }


    public function createEntity() {
        return new Field();
    }

    public function persistEntity(FormInterface $form) {
        /** @var $entity Field */
        $entity = $form->getData();
        $this->fieldsHelper->saveField($entity);
        return $entity;
    }

    public function get($id) {
        $entity = $this->fieldsHelper->findFieldById($id);
        if (!$entity) {
            throw new NotFoundException("field $id not found", $id);
        }
        return $entity;
    }


    public function delete($id) {
        $entity = $this->get($id);
        $this->fieldsHelper->removeField($entity);
    }

    public function all(array $filters) {
        return null;//$this->getRepository()->getFilter($filters);
    }

    public function count(array $filters = null) {
        return null;//$this->getRepository()->getCount($filters);
    }



    public function getConfigForm(Field $field, $method = Request::METHOD_POST) {
        return $this->fieldsHelper->createConfigForm($field, $method);
    }

    public function persistConfig(FormInterface $form) {
        $oId = $form->get('o_id')->getData();
        $field = $this->fieldsHelper->findFieldById($oId);
        if (!$field) {
            throw new NotFoundException("Field $field not found", $field);
        }

        $options = array($field->getFieldType() => $form->getData());
//        ldd($form->getData());
        $this->fieldTypesHelper->saveFieldType($field, $options);

        return $options;
    }



    public function getFields($group) {
        return $this->fieldsHelper->findFieldsByGroup($group);
    }



}



