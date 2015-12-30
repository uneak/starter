<?php

namespace Uneak\PortoAdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\PortoAdminBundle\Handler\CRUDHandler;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutCrudFormEvent extends LayoutCrudActionEvent
{

    /**
     * @var FormInterface
     */
    protected $form;

    public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form)
    {
        parent::__construct($route, $request, $crudHandler);
        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }


}
