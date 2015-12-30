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
		$fields = array();
		foreach ($this->fieldTypes as $field) {
			if ($field['field_data'] == $fieldData) {
				$fields['alias_field'] = $field;
			}
		}
		return $fields;
	}

	public function getFieldType($alias) {
		return $this->fieldTypes[$alias];
	}
	
}
