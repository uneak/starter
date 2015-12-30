<?php

namespace ConstraintBundle\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
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

    public function getConstraints(array $options = null) {
        return $this->constraintsHelper->getConstraints($options);
    }

    public function getConstraint(array $options = null, $id) {
        return $this->constraintsHelper->getConstraint($options, $id);
    }

    public function getConstraintData($alias) {
        return $this->constraintsManager->getConstraint($alias);
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

        $options = $field->getOptions();

        $constraint = array(
            'id' => (isset($ids[1])) ? $ids[1] : '',
            'alias' => $type,
            'parameters' => $form->getData()
        );

        $this->constraintsHelper->addConstraint($options, $constraint);

        $field->setOptions($options);
        $this->em->flush($field);

        return $constraint;
    }


    public function get($id) {
        $ids = explode('/', $id);

        /** @var $field Field */
        $field = $this->getRepository()->findOneById($ids[0]);
        if (!$field) {
            throw new NotFoundException($this->entityClass." ".$ids[0]." not found", $id);
        }

        $options = $field->getOptions();

        $constraint = $this->constraintsHelper->getConstraint($options, $ids[1]);
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

        $options = $field->getOptions();
        $this->constraintsHelper->removeConstraint($options, $ids[1]);

        $field->setOptions($options);
        $this->em->flush($field);
    }

}