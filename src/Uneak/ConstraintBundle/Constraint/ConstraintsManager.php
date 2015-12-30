<?php

	namespace Uneak\ConstraintBundle\Constraint;


	class ConstraintsManager {

		protected $constraints;

		public function __construct() {
			$this->constraints = array();
		}

		public function addConstraint($alias, $aliasConfig, $constraint, $label = null) {
			$this->constraints[$alias] = array(
				'constraint' => $constraint,
				'label' => ($label) ? $label : $alias,
				'alias' => $alias,
				'alias_config' => $aliasConfig,
			);
		}

		public function hasConstraint($alias) {
			return isset($this->constraints[$alias]);
		}

		public function getConstraints() {
			return $this->constraints;
		}


		public function getConstraint($alias) {
			return $this->constraints[$alias];
		}


		public function getConstraintObject($alias, array $parameters = null) {
			$class = $this->constraints[$alias]['constraint'];

			if ($parameters) {
				return new $class($parameters);
			} else {
				return new $class();
			}
		}

		public function resolveConstraints($constraints) {
			if (is_array($constraints)) {
				foreach ($constraints as &$constraint) {
					$this->_resolveConstraint($constraint);
				}
			} else {
				$this->_resolveConstraint($constraints);
			}
			return $constraints;
		}

		private function _resolveConstraint(&$constraint) {
			$parameters = (isset($constraint['parameters'])) ? $constraint['parameters'] : null;
			$constraint = $this->getConstraintObject($constraint['alias'], $parameters);
		}
	}
