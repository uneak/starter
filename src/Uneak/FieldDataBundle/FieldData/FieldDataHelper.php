<?php

namespace Uneak\FieldDataBundle\FieldData;


use Doctrine\ORM\EntityManagerInterface;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldDataBundle\Entity\FieldData;
use Uneak\ProspectBundle\Entity\Prospect;

class FieldDataHelper {

    const ALIAS_EMAIL = "email";
    const ALIAS_FIRSTNAME = "firstName";
    const ALIAS_LASTNAME = "lastName";
    const ALIAS_PHONE = "phone";
    const ALIAS_BIRTHDAY = "birthday";
    const ALIAS_INTEGER = "integer";
    const ALIAS_STRING = "string";
    const ALIAS_TEXT = "text";
    const ALIAS_BOOLEAN = "boolean";
    const ALIAS_DATETIME = "datetime";
    const ALIAS_ARRAY = "array";
    const ALIAS_FLOAT = "float";

    const TYPE_INTEGER = "integer";
    const TYPE_STRING = "string";
    const TYPE_TEXT = "text";
    const TYPE_BOOLEAN = "boolean";
    const TYPE_DATETIME = "datetime";
    const TYPE_ARRAY = "array";
    const TYPE_FLOAT = "float";


    static function ALIAS() {
        $labels = array(
            self::ALIAS_FIRSTNAME => "Prénom",
            self::ALIAS_LASTNAME => "Nom",
            self::ALIAS_PHONE => "Téléphone",
            self::ALIAS_EMAIL => "Adresse email",
            self::ALIAS_BIRTHDAY => "Date de naissance",

            self::ALIAS_INTEGER => "Entier",
            self::ALIAS_STRING => "Chaine de caractère",
            self::ALIAS_TEXT => "Bloc de texte",
            self::ALIAS_BOOLEAN => "Booléen",
            self::ALIAS_DATETIME => "Date",
            self::ALIAS_ARRAY => "Tableau",
            self::ALIAS_FLOAT => "Décimale"
        );
        return $labels;
    }

    static function ALIAS_TYPE($alias) {
        $types = array(
            self::ALIAS_EMAIL => self::TYPE_STRING,
            self::ALIAS_FIRSTNAME => self::TYPE_STRING,
            self::ALIAS_LASTNAME => self::TYPE_STRING,
            self::ALIAS_PHONE => self::TYPE_STRING,
            self::ALIAS_BIRTHDAY => self::TYPE_DATETIME,

            self::ALIAS_INTEGER => self::TYPE_INTEGER,
            self::ALIAS_STRING => self::TYPE_STRING,
            self::ALIAS_TEXT => self::TYPE_TEXT,
            self::ALIAS_BOOLEAN => self::TYPE_BOOLEAN,
            self::ALIAS_DATETIME => self::TYPE_DATETIME,
            self::ALIAS_ARRAY => self::TYPE_ARRAY,
            self::ALIAS_FLOAT => self::TYPE_FLOAT
        );
        if (!isset($types[$alias])) {
            throw new \Exception("le type pour l'alias ".$alias." n'existe pas");
        }
        return $types[$alias];
    }

    static function TYPE() {
        $labels = array(
            self::TYPE_INTEGER => "Entier",
            self::TYPE_STRING => "Chaine de caractère",
            self::TYPE_TEXT => "Bloc de texte",
            self::TYPE_BOOLEAN => "Booléen",
            self::TYPE_DATETIME => "Date",
            self::TYPE_ARRAY => "Tableau",
            self::TYPE_FLOAT => "Décimale"
        );
        return $labels;
    }



    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function createFieldData($fieldOrType, Prospect $prospect = null, $value = null)
    {
        /** @var $field Field */
        if (is_string($fieldOrType)) {
            $type = $fieldOrType;
            $field = null;
        } elseif ($fieldOrType instanceof Field) {
            $type = $fieldOrType->getType();
            $field = $fieldOrType;
        } else {
            throw new \Exception("Field or type ".$fieldOrType." n'a pas été reconnu");
        }


        $fieldData = new FieldData();
        $fieldData->setType($type);
        if ($prospect) {
            $prospect->addFieldData($fieldData);
        }
        if ($field) {
            $field->addFieldData($fieldData);
        }
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
