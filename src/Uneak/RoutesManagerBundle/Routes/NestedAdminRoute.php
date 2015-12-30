<?php

namespace Uneak\RoutesManagerBundle\Routes;


class NestedAdminRoute extends NestedRoute {

	protected $entity = null;
	protected $formType = null;
	protected $handler = null;


	public function __construct($id) {
		parent::__construct($id);
	}

	public function getNestedType() {
		return "NestedAdminRoute";
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
		return $this;
	}

    /**
     * @return null
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param null $formType
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * @return null
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param null $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
        return $this;
    }


}
