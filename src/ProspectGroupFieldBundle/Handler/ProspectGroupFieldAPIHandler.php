<?php

namespace ProspectGroupFieldBundle\Handler;


use Uneak\FieldBundle\Entity\Field;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class ProspectGroupFieldAPIHandler extends EntityAPIHandler {

    /**
     * @var EntityManager
     */
    protected $em;
    protected $repository;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em)
    {
        parent::__construct($formFactory, $em);

    }

    public function createEntity() {
        return new Field();
    }

    public function persistConfig(FormInterface $form) {
        $oId = $form->get('o_id')->getData();
        $field = $this->em->getRepository('UneakFieldBundle:Field')->findOneById($oId);
        if (!$field) {
            throw new NotFoundException("Field $field not found", $field);
        }

        $options = $form->getData();
        $field->setOptions($options);

        $this->em->persist($field);
        $this->em->flush();
        return $field;
    }



    public function getFields($group) {
        $fields = $this->em->getRepository('UneakFieldBundle:Field')->findFields($group);
        return $fields;
    }

}