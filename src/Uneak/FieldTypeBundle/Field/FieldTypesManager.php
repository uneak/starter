<?php

namespace Uneak\FieldTypeBundle\Field;


class FieldTypesManager {

	protected $fieldTypes;

	public function __construct() {
		$this->fieldTypes = array();
	}

	public function addFieldType($aliasConfig, $aliasField, $fieldData, $label = null) {
		$this->fieldTypes[$aliasField] = array(
			'label' => ($label) ? $label : $aliasField,
			'field_data' => $fieldData,
			'alias_field' => $aliasField,
			'alias_config' => $aliasConfig,
		);
	}

	public function hasFieldType($alias) {
		return isset($this->fieldTypes[$alias]);
	}

	public function getFieldTypes() {
		return $this->fieldTypes;
	}

	public function getFieldTypesByFieldData($fieldData) {
		$fieldTypes = array();
		foreach ($this->fieldTypes as $field) {
			if ($field['field_data'] == $fieldData) {
				$fieldTypes[$field['alias_field']] = $field;
			}
		}
		return $fieldTypes;
	}

	public function getFieldType($alias) {
		return $this->fieldTypes[$alias];
	}
	
}
