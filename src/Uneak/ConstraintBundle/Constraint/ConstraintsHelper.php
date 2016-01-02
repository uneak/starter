<?php

	namespace Uneak\ConstraintBundle\Constraint;


	use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Form\FormFactoryInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\FieldBundle\Entity\Field;

    class ConstraintsHelper {

        /**
         * @var EntityManagerInterface
         */
        private $em;
        /**
         * @var ConstraintsManager
         */
        private $constraintsManager;
        /**
         * @var FormFactoryInterface
         */
        private $formFactory;

        public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, ConstraintsManager $constraintsManager) {
            $this->em = $em;
            $this->constraintsManager = $constraintsManager;
            $this->formFactory = $formFactory;
        }


        public function createConstraint($type, array $parameters = null) {
            $constraint = array(
                'id' => '',
                'alias' => $type,
                'parameters' => $parameters,
            );

            return $constraint;
        }

        public function saveConstraint(Field $field, array $constraint, $andFlush = true) {
            $options = $field->getOptions();

            if (!$options) {
                $options = array();
            }
            if (!isset($options['constraints'])) {
                $options['constraints'] = array();
            }


            if ($constraint['id'] === '') {
                // NEW CONSTRAINT
                if (count($options['constraints'])) {
                    $keys = array_keys($options['constraints']);
                    $last = max($keys);
                    $id = $last + 1;
                } else {
                    $id = 1;
                }
                $constraint['id'] = $id;
            } else {
                // UPDATE CONSTRAINT
                $id = $constraint['id'];
            }


            $options['constraints'][$id] = $constraint;


            $field->setOptions($options);
            $this->em->persist($field);

            if ($andFlush) {
                $this->em->flush();
            }
            return $this;

        }


        public function removeConstraint(Field $field, $constraint, $andFlush = true) {
            $options = $field->getOptions();
            if (!$options || !isset($options['constraints'])) {
                return $this;
            }

            if (is_array($constraint) && isset($constraint['id']) && $constraint['id'] != '') {
                $id = $constraint['id'];
            } else {
                $id = $constraint;
            }

            unset($options['constraints'][$id]);


            $field->setOptions($options);
            $this->em->persist($field);

            if ($andFlush) {
                $this->em->flush();
            }
            return $this;
        }


        public function getConstraints(Field $field) {
            $options = $field->getOptions();
            if ($options && isset($options['constraints'])) {
                return $options['constraints'];
            }
            return array();
        }


        public function getConstraint(Field $field, $id) {
            $options = $field->getOptions();
            if (!$options || !isset($options['constraints']) || !isset($options['constraints'][$id])) {
                return null;
            }
            return $options['constraints'][$id];
        }


        public function hasConstraint(Field $field, $id) {
            $options = $field->getOptions();
            if (!$options || !isset($options['constraints']) || !isset($options['constraints'][$id])) {
                return false;
            }
            return true;
        }


        public function createForm($idOrType, Field $field, $method = Request::METHOD_POST) {

            $fieldId = $field->getId();

            if (is_numeric($idOrType)) {
                $constraint = $this->getConstraint($field, $idOrType);
                $type = $constraint['alias'];
                $id = $fieldId.'/'.$idOrType;

            } else {
                $constraint = $this->createConstraint($idOrType);
                $type = $idOrType;
                $id = $fieldId.'/';

            }

            $constraintData = $this->constraintsManager->getConstraint($type);

            $form = $this->formFactory->create($constraintData['alias_config'], $constraint['parameters'], array('method' => $method));
            $form->add('o_id', 'hidden', array('mapped' => false, 'data' => $id));
            $form->add('o_type', 'hidden', array('mapped' => false, 'data' => $type));

            return $form;

        }
	}
