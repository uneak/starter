<?php

namespace FieldGroupBundle\Handler;


use Uneak\FieldGroupBundle\Entity\FieldGroup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class FieldGroupAPIHandler extends EntityAPIHandler {



    public function __construct(FormFactoryInterface $formFactory, EntityManager $em)
    {
        parent::__construct($formFactory, $em);

    }

    public function createEntity() {
        return new FieldGroup();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function get($id) {
        $entity = $this->em->getRepository('UneakFieldGroupBundle:FieldGroup')->findOneBy(array('id' => $id));
        if (!$entity) {
            throw new NotFoundException("FieldGroup $id not found", $id);
        }
        return $entity;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->em->remove($entity);
        $this->em->flush();
    }


    public function all(array $filters) {
        return $this->repository->getFilter($filters);
    }

    public function count(array $filters = null) {
        return $this->repository->getCount($filters);
    }

}