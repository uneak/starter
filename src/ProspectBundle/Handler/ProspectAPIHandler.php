<?php

namespace ProspectBundle\Handler;


use Symfony\Component\HttpFoundation\Request;
use Uneak\FieldGroupBundle\Group\FieldGroupsHelper;
use Uneak\ProspectBundle\Entity\Prospect;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Uneak\PortoAdminBundle\Exception\NotFoundException;
use Uneak\PortoAdminBundle\Handler\EntityAPIHandler;
use Uneak\ProspectBundle\Prospect\ProspectsManager;

class ProspectAPIHandler extends EntityAPIHandler {


    /**
     * @var ProspectsManager
     */
    protected $prospectsManager;
    /**
     * @var FieldGroupsHelper
     */
    private $fieldGroupsHelper;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, ProspectsManager $prospectsManager, FieldGroupsHelper $fieldGroupsHelper)
    {
        parent::__construct($formFactory, $em);
        $this->prospectsManager = $prospectsManager;
        $this->fieldGroupsHelper = $fieldGroupsHelper;
    }


    public function getProspectsFieldsByGroup($group = null) {
        return $this->prospectsManager->findProspectsFieldsByGroup($group);
    }

    public function getProspectsArray(array $criteria = array()) {
        return $this->prospectsManager->getProspectsArray($criteria);
    }

    public function getForm($formType, $entity, $method = Request::METHOD_PUT) {
        return $this->fieldGroupsHelper->createForm($formType, $entity, $method);
    }




    public function createEntity() {
        return $this->prospectsManager->createProspect();
    }

    public function get($id) {
        $entity = $this->prospectsManager->findProspectById($id);
        if (!$entity) {
            throw new NotFoundException($this->entityClass." $id not found", $id);
        }
        return $entity;
    }

    public function delete($id) {
        $entity = $this->get($id);
        $this->prospectsManager->removeProspect($entity);
    }


//		TODO: faire les class ci dessous

//		public function all(array $filters) {
//			return $this->getRepository()->getFilter($filters);
//		}
//
//		public function count(array $filters = null) {
//			return $this->getRepository()->getCount($filters);
//		}




    public function persistEntity(FormInterface $form) {
        $formProspect = $form->get('o_prospect')->getData();
        $prospect = $this->prospectsManager->findProspectById($formProspect);
        if (!$prospect) {
//				$gslug = $form->get('o_group')->getData();
//				$prospect = $this->prospectsManager->createProspect($gslug);
            $prospect = $this->prospectsManager->createProspect();
        }

        $data = $form->getData();
        foreach ($data as $key => $value) {
            $this->prospectsManager->setField($prospect, $key, $value);
        }

        $this->prospectsManager->saveProspect($prospect);
        return $prospect;
    }
}