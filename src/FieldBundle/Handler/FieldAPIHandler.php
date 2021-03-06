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

    public function all(array $criteria) {
        return $this->getRepository()->getAll($criteria);
    }

    public function count(array $criteria = null) {
        return $this->getRepository()->getCount($criteria);
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

        $data = $this->clearFormData($form->getData());

        $options = array($field->getFieldType() => $data);
        $this->fieldTypesHelper->saveFieldType($field, $options);

        return $options;
    }

    private function clearFormData($data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->clearFormData($data[$key]);
            }
            if (empty($data[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }


    public function getFields($group) {
        return $this->fieldsHelper->findFieldsByGroup($group);
    }



}



