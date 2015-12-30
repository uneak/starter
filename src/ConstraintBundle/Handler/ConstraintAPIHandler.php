<?php

namespace ConstraintBundle\Handler;


use ConstraintBundle\Entity\Constraint;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\ConstraintBundle\Constraint\ConstraintsHelper;
use Uneak\ConstraintBundle\Constraint\ConstraintsManager;
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

    public function getConstraintData($alias) {
        return $this->constraintsManager->getConstraint($alias);
    }
}