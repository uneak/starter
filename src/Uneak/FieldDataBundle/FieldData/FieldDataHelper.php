<?php

namespace Uneak\FieldDataBundle\FieldData;


use Doctrine\ORM\EntityManagerInterface;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldDataBundle\Entity\FieldData;
use Uneak\ProspectBundle\Entity\Prospect;

class FieldDataHelper {


    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var FieldDatasManager
     */
    private $fieldDatasManager;

    public function __construct(EntityManagerInterface $em, FieldDatasManager $fieldDatasManager) {
        $this->em = $em;
        $this->fieldDatasManager = $fieldDatasManager;
    }

    public function createFieldData($type, Prospect $prospect = null, Field $field = null, $value = null)
    {
        $typeClass = $this->fieldDatasManager->getFieldDataClass($type);
        $fieldData = new $typeClass();
        $fieldData->setProspect($prospect);
        $fieldData->setField($field);
        $fieldData->setValue($value);
        return $fieldData;
    }

    public function saveFieldData(FieldData $fieldData, $andFlush = true) {
        $this->em->persist($fieldData);
        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

    public function removeFieldData(FieldData $fieldData, $andFlush = true)
    {
        $this->em->remove($fieldData);
        if ($andFlush) {
            $this->em->flush();
        }
        return $this;
    }

}
