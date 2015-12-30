<?php

namespace Uneak\RoutesManagerBundle\Routes;


class NestedGridRoute extends NestedAdminRoute {

	protected $rowActions = array();
	protected $columns = array();
	protected $ids = array();
	protected $gridRoute;

	public function __construct($id) {
		parent::__construct($id);

		$this->gridRoute = new NestedRoute('_grid');
		$this->gridRoute->setPath('_grid');
		$this->gridRoute->setAction('grid');
		$this->addChild($this->gridRoute);

	}

	public function getGridRoute() {
		return $this->gridRoute;
	}

	public function addRowAction($key, $path) {
		$this->rowActions[$key] = $path;
		return $this;
	}

	public function addId($key, $path) {
		$this->ids[$key] = $path;
		return $this;
	}

	public function getIds() {
		return $this->ids;
	}

	public function getRowAction($key) {
		return $this->rowActions[$key];
	}

	public function getRowActions() {
		return $this->rowActions;
	}

	public function addColumn($array) {
		$this->columns[] = $array;
		return $this;
	}

	public function getColumns() {
		return $this->columns;
	}

}
