<?php

namespace UserBundle\Handler;


use Doctrine\ORM\EntityManager;
use FOS\OAuthServerBundle\Entity\userManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class UserAPIHandler extends EntityAPIHandler {

    /**
     * @var UserManagerInterface
     */
    private $userManager;


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, UserManagerInterface $userManager)
    {
        parent::__construct($formFactory, $em);

        $this->userManager = $userManager;
    }

    public function createEntity() {
        return $this->userManager->createUser();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->userManager->updateUser($entity);
        return $entity;
    }

    public function get($id) {
        $client = $this->userManager->findUserBy(array("id" => $id));

        if (!$client) {
            throw new NotFoundException("User $id not found", $id);
        }
        return $client;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->userManager->deleteUser($entity);
    }


    public function all(array $criteria) {
        return $this->repository->getAll($criteria);
    }

    public function count(array $criteria = null) {
        return $this->repository->getCount($criteria);
    }

}