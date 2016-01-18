<?php

	namespace Uneak\FieldSearchBundle\Field\SearchType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class BooleanSearchType extends SearchType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
            $builder

                ->add('check', 'checkbox', array(
                    'label' => "Coché ou pas"
                ))

            ;
		}

		static public function buildQuery(array &$query, $key, array $data) {
			if (!isset($query['eq'])) {
				$query['eq'] = array();
			}

			$query['eq'][$key] = intval($data['check']);
        }

		/**
		 * @return string
		 */
		public function getName() {
			return 'search_boolean';
		}
	}
