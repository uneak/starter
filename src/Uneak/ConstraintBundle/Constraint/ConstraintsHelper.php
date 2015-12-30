<?php

	namespace Uneak\ConstraintBundle\Constraint;


	class ConstraintsHelper {

        public function getConstraints(array $options = null) {
            if ($options && isset($options['constraints'])) {
                return $options['constraints'];
            }
            return array();
        }

        public function setConstraints(array &$options = null, array $constraints = null) {
            if (!$options) {
                $options = array();
            }
            if (!$constraints) {
                $constraints = array();
            }
            $options['constraints'] = $constraints;
        }

        public function addConstraint(array &$options = null, array $constraint) {
            if (!$options) {
                $options = array();
            }
            if (!isset($options['constraints'])) {
                $options['constraints'] = array();
            }

            $options['constraints'][$constraint['id']] = $constraint;
        }

        public function removeConstraint(array &$options = null, $id) {
            if (!$options || !isset($options['constraints'])) {
                return;
            }

            unset($options['constraints'][$id]);
        }

        public function hasConstraint(array &$options = null, $id) {
            if (!$options || !isset($options['constraints']) || !isset($options['constraints'][$id])) {
                return false;
            }
            return true;
        }
	}
