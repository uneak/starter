<?php

namespace Uneak\PortoAdminBundle\Handler;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface APIHandlerInterface
{

    public function createEntity();
    public function persistEntity(FormInterface $form);

    public function get($id);
    public function delete($id);
    public function all(array $filters);
    public function count(array $filters = null);
    public function post($formType, array $parameters);
    public function put($formType, $entity, array $parameters);
    public function patch($formType, $entity, array $parameters);

    /**
     * @param $formType
     * @param $entity
     * @param string $method
     * @return FormInterface
     */
    public function getForm($formType, $entity, $method = Request::METHOD_PUT);
    public function submitForm(FormInterface $form, array $parameters);
    public function processForm(FormInterface $form, array $parameters);

}