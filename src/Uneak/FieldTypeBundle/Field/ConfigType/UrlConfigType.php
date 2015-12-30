<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class UrlConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
			$builder
				->add('default_protocol', null, array(
					'empty_data'  => null,
				))
				;
		}

		/**
		 * @return string
		 */
		public function getName() {
			return 'config_url';
		}
	}
