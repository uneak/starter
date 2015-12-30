<?php

namespace Uneak\FieldTypeBundle\Field;


use Uneak\ConstraintBundle\Constraint\ConstraintsHelper;

class FieldTypesHelper {


    /**
     * @var ConstraintsHelper
     */
    private $constraintsHelper;

    public function __construct(ConstraintsHelper $constraintsHelper) {
        $this->constraintsHelper = $constraintsHelper;
    }



}
