<?php

namespace Uneak\FieldBundle\Field;


use Uneak\ConstraintBundle\Constraint\ConstraintsHelper;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldTypeBundle\Field\FieldTypesManager;

class FieldsHelper {


    /**
     * @var ConstraintsHelper
     */
    private $constraintsHelper;
    /**
     * @var FieldTypesManager
     */
    private $fieldTypesManager;

    public function __construct(FieldTypesManager $fieldTypesManager, ConstraintsHelper $constraintsHelper) {
        $this->constraintsHelper = $constraintsHelper;
        $this->fieldTypesManager = $fieldTypesManager;
    }


    public function getFieldType(Field $field) {
        if ($field->getFieldType()) {
            return $this->fieldTypesManager->getFieldType($field->getFieldType());
        } else {
            return $this->fieldTypesManager->getFieldTypesByFieldData($field->getType());
        }
    }

    public function getConstraints(Field $field) {
        return $this->constraintsHelper->getConstraints($field->getOptions());
    }


}
