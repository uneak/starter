<?php

namespace Uneak\FieldDataBundle\FieldData;


class FieldDatasManager {

	protected $fieldDatas;

	public function __construct() {
		$this->fieldDatas = array();
	}

	public function addFieldData($alias, $class, $label = null) {
		$this->fieldDatas[$alias] = array(
			'label' => ($label) ? $label : $alias,
			'alias' => $alias,
			'class' => $class,
		);
	}

	public function hasFieldData($alias) {
		return isset($this->fieldDatas[$alias]);
	}

	public function getFieldDatas() {
		return $this->fieldDatas;
	}

	public function getFieldData($alias) {
		return $this->fieldDatas[$alias];
	}

	public function getFieldDataClass($alias) {
		return $this->fieldDatas[$alias]['class'];
	}

}
