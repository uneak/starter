<?php

namespace Uneak\FieldSearchBundle\Field;


class FieldSearchManager {

	protected $fieldSearchs;

	public function __construct() {
		$this->fieldSearchs = array();
	}

	public function addFieldSearch($aliasSearch, $aliasField, $fieldData) {
		$this->fieldSearchs[$aliasField] = array(
			'field_data' => $fieldData,
			'alias_field' => $aliasField,
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
				$fieldSearchs[$field['alias_field']] = $field;
			}
		}
		return $fieldSearchs;
	}

	public function getFieldSearch($alias) {
		return $this->fieldSearchs[$alias];
	}
	
}
