<?php

namespace Uneak\FieldGroupBundle\Group;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\ConstraintBundle\Constraint\ConstraintsManager;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldBundle\Field\FieldsHelper;
use Uneak\FieldGroupBundle\Entity\FieldGroup;
use Uneak\FieldGroupBundle\Form\FieldGroupType;
use Uneak\ProspectBundle\Entity\Prospect;
use Uneak\ProspectBundle\Prospect\ProspectsManager;

class FieldGroupsHelper {


    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ConstraintsManager
     */
    private $constraintsManager;
    /**
     * @var FieldsHelper
     */
    private $fieldsHelper;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, ConstraintsManager $constraintsManager, FieldsHelper $fieldsHelper) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->constraintsManager = $constraintsManager;
        $this->fieldsHelper = $fieldsHelper;
    }


    public function createForm($group, Prospect $prospect = null, $method = Request::METHOD_POST) {
        $id = 0;
        $data = array();

        if ($prospect) {
            $id = $prospect->getId();
            $prospectFields = $this->fieldsHelper->findFieldsByProspects(array($id));
            /** @var $field Field */
            foreach ($prospectFields as $field) {
                $data[$field->getSlug()] = $prospect->getField($field->getSlug());
            }
        }

        if ($group) {
            $fields = $this->getFormFields($this->fieldsHelper->findFieldsByGroup($group));
        } elseif (isset($prospectFields)) {
            $fields = $this->getFormFields($prospectFields);
        } else {
            throw new Exception("Impossible de creer le formulaire avec le group: ".$group." et le prospect: ".$prospect);
        }

        $formType = new FieldGroupType($fields);

        $form = $this->formFactory->create($formType, $data, array('method' => $method));
        $form->add('o_group', 'hidden', array('mapped' => false, 'data' => $group));
        $form->add('o_prospect', 'hidden', array('mapped' => false, 'data' => $id));

        return $form;

    }



    protected function getFormFields($dbFields) {
        $fields = array();
        /** @var $dbField Field */
        foreach ($dbFields as $dbField) {
            $field = array(
                'slug' => $dbField->getSlug(),
                'type' => $dbField->getFieldType(),
                'options' => $dbField->getOptions(),
            );

            if (isset($field['options']['constraints'])) {
                $field['options']['constraints'] = $this->constraintsManager->resolveConstraints($field['options']['constraints']);
            }

            $fields[$dbField->getSlug()] = $field;
        }

        return $fields;
    }



}