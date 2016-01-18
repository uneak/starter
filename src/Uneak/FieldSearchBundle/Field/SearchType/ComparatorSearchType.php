<?php

	namespace Uneak\FieldSearchBundle\Field\SearchType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Validator\Constraints\Collection;

    abstract class ComparatorSearchType extends SearchType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
            $builder
                ->add('operator', 'choice', array(
                    'label' => "Opérateur",
                    'choices' => array(
                        'eq' => "Egale",
                        'ne' => "Différent",
                        'lt' => "Inférieur",
                        'gt' => "Supérieur",
                        'le' => "Inférieur ou égale",
                        'ge' => "Supérieur ou égale",
                        'bw' => "Entre",
                    ),
                ))
            ;
		}


        static public function buildQuery(array &$query, $key, array $data) {
            if ($data['operator'] == 'bw') {
                if (!isset($query['ge'])) {
                    $query['ge'] = array();
                }
                if (!isset($query['le'])) {
                    $query['le'] = array();
                }

                $max = max($data['value1'], $data['value2']);
                $min = min($data['value1'], $data['value2']);
                $query['ge'][$key] = $min;
                $query['le'][$key] = $max;

            } else {
                if (!isset($query[$data['operator']])) {
                    $query[$data['operator']] = array();
                }

                $query[$data['operator']][$key] = $data['value1'];
            }

        }

		/**
		 * @return string
		 */
		public function getName() {
			return 'search_comparator';
		}
	}
