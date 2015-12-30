<?php

namespace Uneak\PortoAdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\PortoAdminBundle\Handler\CRUDHandler;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutCrudSubmittedFormEvent extends LayoutCrudFormEvent
{

    /**
     * @var array
     */
    private $flash;

    public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form, array $flash)
    {
        parent::__construct($route, $request, $crudHandler, $form);
        $this->flash = $flash;
    }

    /**
     * @return array
     */
    public function getFlash()
    {
        return $this->flash;
    }

    /**
     * @param array $flash
     */
    public function setFlash($flash)
    {
        $this->flash = $flash;
    }




}
