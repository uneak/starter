<?php

	namespace Uneak\ConstraintBundle\Constraint\ConfigType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class NotBlankConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
			$builder
				->add('message', 'text', array(
					'label' => "Message",
				))
			;
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'config_constraint_notblank';
		}
	}
