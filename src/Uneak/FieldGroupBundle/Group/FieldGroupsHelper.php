<?php

namespace Uneak\FieldGroupBundle\Group;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\ConstraintBundle\Constraint\ConstraintsManager;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldGroupBundle\Form\FieldGroupType;
use Uneak\ProspectBundle\Entity\Prospect;
use Uneak\ProspectBundle\Prospect\ProspectsManager;

class FieldGroupsHelper {


    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var ProspectsManager
     */
    private $prospectsManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ConstraintsManager
     */
    private $constraintsManager;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, ProspectsManager $prospectsManager, ConstraintsManager $constraintsManager) {
        $this->formFactory = $formFactory;
        $this->prospectsManager = $prospectsManager;
        $this->em = $em;
        $this->constraintsManager = $constraintsManager;
    }


    public function createForm($group, Prospect $prospect = null, $method = Request::METHOD_POST) {

        $id = 0;
        $data = array();


        if ($prospect) {
            $id = $prospect->getId();
            $prospectFields = $this->getProspectFields($prospect);
            /** @var $field Field */
            foreach ($prospectFields as $field) {
                $data[$field->getSlug()] = $prospect->getField($field->getSlug());
            }
        }

        if ($group) {
            $fields = $this->getFormFields($this->getFieldGroupFields($group));
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


    public function getProspectFields(Prospect $prospect) {
        return $this->prospectsManager->findFieldsByProspects(array($prospect->getId()));
    }

    protected function getFormFields($dbFields) {
        $fields = array();
        /** @var $dbField Field */
        foreach ($dbFields as $dbField) {
            $field = array(
                'slug' => $dbField->getSlug(),
                'type' => $dbField->getType(),
                'options' => $dbField->getOptions(),
            );



            if (isset($field['options']['constraints'])) {
                $field['options']['constraints'] = $this->constraintsManager->resolveConstraints($field['options']['constraints']);
            }

            $fields[$dbField->getSlug()] = $field;
        }

        return $fields;
    }




    public function getFieldGroupFields($group) {
        $qb = $this->em->createQueryBuilder();
        $qb->select('field');
        $qb->from('UneakFieldBundle:Field', 'field');
        $qb->innerJoin('field.group', 'fieldGroup');
        $qb->where($qb->expr()->eq('fieldGroup.slug', ':group'));
        $qb->setParameter("group", $group);
        $qb->orderBy("field.sort", "ASC");

        return $qb->getQuery()->getResult();
    }

}