<?php

namespace CampaignBundle\Handler;


use CampaignBundle\Entity\Campaign;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class CampaignAPIHandler extends EntityAPIHandler {


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em)
    {
        parent::__construct($formFactory, $em);

    }

    public function createEntity() {
        return new Campaign();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function get($id) {
        $entity = $this->em->getRepository('CampaignBundle:Campaign')->findOneBy(array('id' => $id));
        if (!$entity) {
            throw new NotFoundException("Campaign $id not found", $id);
        }
        return $entity;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->em->remove($entity);
        $this->em->flush();
    }


    public function all(array $criteria) {
        return $this->repository->getAll($criteria);
    }

    public function count(array $criteria = null) {
        return $this->repository->getCount($criteria);
    }

}