<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use IntlDateFormatter;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class DateConfigType extends ConfigType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);

			$builder
				->add('options', new BsDateTimeConfigType())
				->add('input', 'hidden', array(
					'data' => 'string'
				))
				;

		}




		/**
		 * @return string
		 */
		public function getName() {
			return 'config_uneak_date_picker';
		}
	}
