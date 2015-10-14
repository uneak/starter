<?php

namespace Uneak\PortoAdminBundle\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\PortoAdminBundle\Exception\InvalidFormException;

abstract class AbstractAPIHandler implements APIHandlerInterface {


    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;


    public function __construct(FormFactoryInterface $formFactory) {
        $this->formFactory = $formFactory;
    }

    abstract public function createEntity();
    abstract public function persistEntity(FormInterface $form);
    abstract public function get($id);
    abstract public function delete($id);
    abstract public function all(array $filters);

    public function post($formType, array $parameters)
    {
        $entity = $this->createEntity();
        $form = $this->getForm($formType, $entity, Request::METHOD_POST);
        return $this->processForm($form, $parameters);
    }

    public function put($formType, $entity, array $parameters)
    {
        $form = $this->getForm($formType, $entity, Request::METHOD_PUT);
        return $this->processForm($form, $parameters);
    }

    public function patch($formType, $entity, array $parameters)
    {
        $form = $this->getForm($formType, $entity, Request::METHOD_PATCH);
        return $this->processForm($form, $parameters);
    }

    public function getForm($formType, $entity, $method = Request::METHOD_PUT) {
        return $this->formFactory->create($formType, $entity, array('method' => $method));
    }

    public function submitForm(FormInterface $form, array $parameters) {
        $form->submit($parameters, $form->getConfig()->getMethod() !== Request::METHOD_PATCH);
        return $form->isValid();
    }

    public function processForm(FormInterface $form, array $parameters) {
        $isValid = $this->submitForm($form, $parameters);
        if ($isValid) {
            return $this->persistEntity($form);
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

}