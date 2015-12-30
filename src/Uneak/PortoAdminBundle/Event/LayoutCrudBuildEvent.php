<?php

namespace Uneak\PortoAdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Uneak\PortoAdminBundle\Handler\CRUDHandler;
use Uneak\PortoAdminBundle\LayoutBuilder\LayoutBuilderInterface;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutCrudBuildEvent extends LayoutCrudActionEvent
{

    /**
     * @var LayoutBuilderInterface
     */
    private $layout;

    public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, LayoutBuilderInterface $layout)
    {
        parent::__construct($route, $request, $crudHandler);

        $this->layout = $layout;
    }

    /**
     * @return LayoutBuilderInterface
     */
    public function getLayout()
    {
        return $this->layout;
    }


}
