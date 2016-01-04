<?php

	namespace Uneak\FieldSearchBundle\Field\SearchType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class IntegerSearchType extends ComparatorSearchType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
            $builder

                ->add('value1', 'integer', array(
                    'label' => "Valeur"
                ))
                ->add('value2', 'integer', array(
                    'label' => "Valeur"
                ))
            ;
		}

        public function buildQuery(array &$query, $key, array $data) {
            parent::buildQuery($query, $key, $data);

        }

		/**
		 * @return string
		 */
		public function getName() {
			return 'search_integer';
		}
	}
