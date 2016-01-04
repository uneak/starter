<?php

namespace OAuthServerBundle\Handler;


use Doctrine\ORM\EntityManager;
use FOS\OAuthServerBundle\Entity\ClientManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class OauthServerAPIHandler extends EntityAPIHandler {

    /**
     * @var ClientManager
     */
    private $clientManager;
    /**
     * @var EntityManager
     */
    protected $em;
    protected $entityClass;
    protected $repository;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, $entityClass, ClientManager $clientManager)
    {
        parent::__construct($formFactory, $em, $entityClass);
        $this->clientManager = $clientManager;
    }

    public function createEntity() {
        return $this->clientManager->createClient();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->clientManager->updateClient($entity);
        return $entity;
    }

    public function get($id) {
        $client = $this->clientManager->findClientBy(array("id" => $id));
        if (!$client) {
            throw new NotFoundException("OAuth client $id not found", $id);
        }
        return $client;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->clientManager->deleteClient($entity);
    }


    public function all(array $criteria) {
        return $this->repository->getAll($criteria);
    }

    public function count(array $criteria = null) {
        return $this->repository->getCount($criteria);
    }

}