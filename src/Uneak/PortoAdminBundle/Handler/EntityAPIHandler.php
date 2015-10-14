<?php

namespace Uneak\PortoAdminBundle\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;

class EntityAPIHandler extends AbstractAPIHandler implements APIHandlerInterface {

    /**
     * @var EntityManager
     */
    protected $em;

    protected $entityClass;
    protected $repository;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, $entityClass)
    {
        parent::__construct($formFactory);
        $this->em = $em;
        $this->entityClass = $entityClass;
        $this->repository = $em->getRepository($entityClass);
    }

    public function createEntity()
    {
        return new $this->entityClass();
    }

    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->em->persist($entity);
        $this->em->flush($entity);
        return $entity;
    }

    public function get($id)
    {
        $client = $this->repository->find($id);
        if (!$client) {
            throw new NotFoundException("$id not found", $id);
        }
        return $client;

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