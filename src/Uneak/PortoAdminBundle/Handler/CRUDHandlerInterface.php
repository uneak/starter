<?php

namespace Uneak\PortoAdminBundle\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

interface CRUDHandlerInterface
{
    /**
     * @param FlattenRoute $route
     * @param string $method
     * @return FormInterface
     */
    public function getForm(FlattenRoute $route, $method = Request::METHOD_POST);
    public function createEntity();
    public function persistEntity(FormInterface $form);
    public function submitForm(FormInterface $form, array $parameters);
    public function processForm(FormInterface $form, array $parameters);

}