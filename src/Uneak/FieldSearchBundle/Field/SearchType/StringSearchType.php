<?php

	namespace Uneak\FieldSearchBundle\Field\SearchType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class StringSearchType extends SearchType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
            $builder
                ->add('like', 'text', array(
                    'label' => "Texte",
                    'attr' => array(
                        'help_text' => "utiliser le caractère '%' comme jocker",
                    )
                ))
            ;
		}


        public function buildQuery(array &$query, $key, array $data) {
            if (!isset($query['like'])) {
                $query['like'] = array();
            }

            $query['like'][$key] = $data['like'];
        }

		/**
		 * @return string
		 */
		public function getName() {
			return 'search_string';
		}
	}
