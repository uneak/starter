<?php

namespace ImportBundle\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\ImportBundle\Entity\Import;
use Uneak\ImportBundle\Reader\CsvReader;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;

class ImportAPIHandler extends EntityAPIHandler {


    public function __construct(FormFactoryInterface $formFactory, EntityManager $em)
    {
        parent::__construct($formFactory, $em);

    }

    public function persistImport(Import $import) {
        $this->em->persist($import);
        $this->em->flush();
        return $import;
    }


    public function get($id) {
        $entity = $this->em->getRepository('UneakImportBundle:Import')->findOneBy(array('id' => $id));
        if (!$entity) {
            throw new NotFoundException("Import $id not found", $id);
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