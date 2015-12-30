<?php

namespace ProspectBundle\Handler;


use Uneak\ProspectBundle\Entity\Prospect;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class ProspectAPIHandler extends EntityAPIHandler {

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
        return new Prospect();
    }


    public function persistEntity(FormInterface $form) {
        $entity = $form->getData();
        $this->em->persist($entity);
        $this->em->flush();

        if (!$entity->getSlug()) {
            $string = $entity->getId() . $entity->getGroup()->getId();
            $data = base64_encode($string);
            $no_of_eq = substr_count($data, "=");
            $data = str_replace("=", "", $data);
            $data = $data . $no_of_eq;
            $data = str_replace(array('+', '/'), array('-', '_'), $data);

            $entity->setSlug($data);
            $this->em->flush();
        }


        return $entity;
    }

    public function get($id) {
        $entity = $this->em->getRepository('ProspectBundle:Prospect')->findOneBySlug($id);
        if (!$entity) {
            throw new NotFoundException("Prospect $id not found", $id);
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