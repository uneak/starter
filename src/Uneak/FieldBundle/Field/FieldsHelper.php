<?php

namespace Uneak\FieldBundle\Field;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Uneak\ConstraintBundle\Constraint\ConstraintsHelper;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldDataBundle\Entity\FieldData;
use Uneak\FieldDataBundle\FieldData\FieldDataHelper;
use Uneak\FieldDataBundle\FieldData\FieldDatasManager;
use Uneak\FieldGroupBundle\Entity\FieldGroup;
use Uneak\FieldTypeBundle\Field\FieldTypesHelper;
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
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var FieldDatasManager
     */
    private $fieldDatasManager;
    /**
     * @var FieldDataHelper
     */
    private $fieldDataHelper;
    /**
     * @var FieldTypesHelper
     */
    private $fieldTypesHelper;
    /**
     * @var FormFactory
     */
    private $formFactory;


    public function __construct(EntityManagerInterface $em, FieldTypesManager $fieldTypesManager, ConstraintsHelper $constraintsHelper, FieldDatasManager $fieldDatasManager, FieldDataHelper $fieldDataHelper, FieldTypesHelper $fieldTypesHelper, FormFactory $formFactory) {
        $this->em = $em;
        $this->fieldTypesManager = $fieldTypesManager;
        $this->constraintsHelper = $constraintsHelper;
        $this->fieldDatasManager = $fieldDatasManager;
        $this->fieldDataHelper = $fieldDataHelper;
        $this->fieldTypesHelper = $fieldTypesHelper;
        $this->formFactory = $formFactory;
    }


    /**
     * @param FieldGroup $group
     * @param $label
     * @param string $type
     * @param int $sort
     * @param null $slug
     * @return Field
     */
    public function createField(FieldGroup $group, $label, $type = 'string', $sort = 0, $slug = null) {
        $field = new Field();
        $field->setGroup($group);
        $field->setLabel($label);
        $field->setType($type);
        $field->setSort($sort);
        $field->setSlug($slug);

        return $field;
    }

    public function removeField(Field $field, $andFlush = true) {
        $this->em->remove($field);
        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    public function saveField(Field $field, $andFlush = true) {
        $this->updateFieldDataType($field);
        if ($field->getFieldType() == null) {
            $this->fieldTypesHelper->removeFieldType($field, false);
        }

        $this->em->persist($field);
        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }



    protected function updateFieldDataType(Field $field) {

        $typeClass = $this->fieldDatasManager->getFieldDataClass($field->getType());

        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('fieldData')
            ->from('UneakFieldDataBundle:FieldData', 'fieldData')
            ->innerJoin('fieldData.field', 'field')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('field.id', ':fieldId'),
                    'fieldData NOT INSTANCE OF '.$typeClass
                )
            )
            ->setParameter("fieldId", $field->getId())
        ;

        $fieldDatas = $qb->getQuery()->getResult();


        if (count($fieldDatas)) {
            /** @var $fieldData FieldData */
            foreach ($fieldDatas as $fieldData) {
                $nFieldData = $this->fieldDataHelper->createFieldData($field->getType(), $fieldData->getProspect(), $field, $fieldData->getValue());
                $this->fieldDataHelper->saveFieldData($nFieldData, false);
                $this->fieldDataHelper->removeFieldData($fieldData, false);
            }
            $this->fieldTypesHelper->removeFieldType($field, false);
        }

    }



    public function findFieldsByProspects(array $prospectsId) {
        $qb = $this->em->createQueryBuilder();
        $qb->select('field');
        $qb->from('UneakFieldBundle:Field', 'field');
        $qb->leftJoin('UneakFieldDataBundle:FieldData', 'fieldData', Join::WITH, $qb->expr()->eq('fieldData.field', 'field'));
        $qb->innerJoin('fieldData.prospect', 'prospect');
        $qb->where($qb->expr()->in('prospect.id', $prospectsId));
        $qb->orderBy("field.sort", "DESC");

        return $qb->getQuery()->getResult();
    }

    public function findFieldBySlug($slug) {
        $repository = $this->em->getRepository('UneakFieldBundle:Field');
        return $repository->findOneBy(array('slug' => $slug));
    }

    public function findFieldById($id) {
        $repository = $this->em->getRepository('UneakFieldBundle:Field');
        return $repository->findOneBy(array('id' => $id));
    }

    public function findFieldsByGroup($group) {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('field')
            ->from('UneakFieldBundle:Field', 'field')
            ->innerJoin('field.group', 'fieldgroup')
            ->setParameter("fieldgroup", $group)
            ->orderBy("field.sort", "DESC")
        ;

        if ($group instanceof FieldGroup || is_numeric($group)) {
            $qb->where($qb->expr()->eq('fieldgroup.id', ':fieldgroup'));
        } else {
            $qb->where($qb->expr()->eq('fieldgroup.slug', ':fieldgroup'));
        }

        return $qb->getQuery()->getResult();
    }





    public function getFieldType(Field $field) {
        if ($field->getFieldType()) {
            return $this->fieldTypesManager->getFieldType($field->getFieldType());
        } else {
            $fieldTypes = $this->fieldTypesManager->getFieldTypesByFieldData($field->getType());
            return reset($fieldTypes);
        }
    }


//    public function getConstraints(Field $field) {
//        return $this->constraintsHelper->getConstraints($field);
//    }



    public function createConfigForm(Field $field, $method = Request::METHOD_POST)
    {
        $options = $field->getOptions();
        $fieldType = $this->getFieldType($field);
        $form = $this->formFactory->create($fieldType['alias_config'], $options, array('method' => $method));
        $form->add('o_id', 'hidden', array('mapped' => false, 'data' => $field->getId()));
        return $form;
    }

}
