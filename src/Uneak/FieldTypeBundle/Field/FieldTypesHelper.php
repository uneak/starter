<?php

namespace Uneak\FieldTypeBundle\Field;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\FieldBundle\Entity\Field;

class FieldTypesHelper {


    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var FieldTypesManager
     */
    private $fieldTypesManager;


    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, FieldTypesManager $fieldTypesManager) {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->fieldTypesManager = $fieldTypesManager;
    }



    public function createFieldType($type, array $options = array()) {
        if (!isset($options['constraints'])) {
            $options['constraints'] = array();
        }
        return array($type => $options);
    }


    public function saveFieldType(Field $field, array $options = null, $andFlush = true) {

        if ($options) {
            $type = array_keys($options)[0];
            $options = reset($options);

            $field->setFieldType($type);
            $field->setOptions($options);
        }

        $this->em->persist($field);

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }


    public function removeFieldType(Field $field, $andFlush = true) {
        $empty = array();
        $options = $field->getOptions();
        if ($options && isset($options['constraints'])) {
            $empty['constraints'] = $options['constraints'];
        }

        $field->setFieldType(null);
        $field->setOptions($empty);
        $this->em->persist($field);

        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    public function getFieldType(Field $field) {
        $options = $field->getOptions();
        return array($field->getFieldType() => $options);
    }


}
