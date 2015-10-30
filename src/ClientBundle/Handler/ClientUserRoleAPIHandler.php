<?php

namespace ClientBundle\Handler;


use ClientBundle\Entity\Client;
use ClientBundle\Entity\ClientUserRole;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class ClientUserRoleAPIHandler extends EntityAPIHandler {

    /**
     * @var EntityManager
     */
    protected $em;
    protected $entityClass;
    protected $repository;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, $entityClass)
    {
        parent::__construct($formFactory, $em, $entityClass);

    }

    public function createEntity() {
        return new ClientUserRole();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function get($id) {
        $entity = $this->em->getRepository('ClientBundle:ClientUserRole')->findOneBy(array('id' => $id));
        if (!$entity) {
            throw new NotFoundException("Client role $id not found", $id);
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