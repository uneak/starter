<?php

namespace Uneak\FieldSearchBundle\Field;


class FieldSearchManager {

	protected $fieldSearchs;

	public function __construct() {
		$this->fieldSearchs = array();
	}

	public function addFieldSearch($aliasSearch, $fieldData) {
		$this->fieldSearchs[$aliasSearch] = array(
			'field_data' => $fieldData,
			'alias_search' => $aliasSearch,
		);
	}

	public function hasFieldSearch($alias) {
		return isset($this->fieldSearchs[$alias]);
	}

	public function getFieldSearchs() {
		return $this->fieldSearchs;
	}

	public function getFieldSearchsByFieldData($fieldData) {
		$fieldSearchs = array();
		foreach ($this->fieldSearchs as $field) {
			if ($field['field_data'] == $fieldData) {
				$fieldSearchs[$field['alias_search']] = $field;
			}
		}
		return $fieldSearchs;
	}

	public function getFieldSearch($alias) {
		return $this->fieldSearchs[$alias];
	}
	
}
