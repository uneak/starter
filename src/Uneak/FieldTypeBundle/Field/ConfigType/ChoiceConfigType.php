<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class ChoiceConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);

			$builder

				->add('multiple', 'checkbox', array(
					'empty_data'  => null,
				))
				->add('expanded', 'checkbox', array(
					'empty_data'  => null,
				))
				->add('choices', 'uneak_collection_key', array(
					'required' => false,
					'label' => "Choix",
					'type' => "uneak_attribute",
					'allow_add' => true,
					'allow_delete' => true,
					'add_button_text' => 'Add',
					'delete_button_text' => 'Remove',
				))
				->add('preferred_choices', null, array(
					'empty_data'  => null,
				))
				->add('empty_value', null, array(
					'empty_data'  => null,
				))


				;
		}




		/**
		 * @return string
		 */
		public function getName() {
			return 'config_choice_select2';
		}
	}
