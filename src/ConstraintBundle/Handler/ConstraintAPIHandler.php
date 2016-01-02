<?php

namespace ConstraintBundle\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\ConstraintBundle\Constraint\ConstraintsHelper;
use Uneak\ConstraintBundle\Constraint\ConstraintsManager;
use Uneak\FieldBundle\Entity\Field;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class ConstraintAPIHandler extends EntityAPIHandler {

    /**
     * @var ConstraintsHelper
     */
    private $constraintsHelper;
    /**
     * @var ConstraintsManager
     */
    private $constraintsManager;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, ConstraintsHelper $constraintsHelper, ConstraintsManager $constraintsManager) {
        parent::__construct($formFactory, $em);
        $this->constraintsHelper = $constraintsHelper;
        $this->constraintsManager = $constraintsManager;
    }

    public function getConstraints(Field $field) {
        return $this->constraintsHelper->getConstraints($field);
    }


    public function getConstraintData($alias) {
        return $this->constraintsManager->getConstraint($alias);
    }






    public function getForm($formType, $entity, $method = Request::METHOD_PUT) {
        return $this->constraintsHelper->createForm($formType, $entity, $method);
    }



    public function persistEntity(FormInterface $form) {

        $id = $form->get('o_id')->getData();
        $type = $form->get('o_type')->getData();
        $ids = explode('/', $id);

        /** @var $field Field */
        $field = $this->getRepository()->findOneById($ids[0]);
        if (!$field) {
            throw new NotFoundException($this->entityClass." ".$ids[0]." not found", $id);
        }

        $constraint = $this->constraintsHelper->createConstraint($type, $form->getData());
        $constraint['id'] = (isset($ids[1])) ? $ids[1] : '';
        $this->constraintsHelper->saveConstraint($field, $constraint);

        return $constraint;
    }


    public function get($id) {
        $ids = explode('/', $id);
        /** @var $field Field */
        $field = $this->getRepository()->findOneById($ids[0]);
        if (!$field) {
            throw new NotFoundException($this->entityClass." ".$ids[0]." not found", $id);
        }

        $constraint = $this->constraintsHelper->getConstraint($field, $ids[1]);
        if (!$constraint) {
            throw new NotFoundException($ids[1]." constraint not found", $id);
        }

        return $constraint;
    }


    public function delete($id) {
        $ids = explode('/', $id);
        /** @var $field Field */
        $field = $this->getRepository()->findOneById($ids[0]);
        if (!$field) {
            throw new NotFoundException($this->entityClass." ".$ids[0]." not found", $id);
        }

        $constraint = $this->get($id);
        $this->constraintsHelper->removeConstraint($field, $constraint);

    }

}