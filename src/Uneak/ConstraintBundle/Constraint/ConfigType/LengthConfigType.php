<?php

	namespace Uneak\ConstraintBundle\Constraint\ConfigType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class LengthConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
			$builder
				->add('min', 'number', array(
					'label' => "Longueur minimum",
				))
				->add('minMessage', 'text', array(
					'label' => "min Message",
					'attr' => array(
						'help_text' => "The message that will be shown if the underlying value's length is less than the min option.<br/><strong>default:</strong> This value is too short. It should have {{ limit }} characters",
					)
				))
				->add('max', 'number', array(
					'label' => "Longueur maximum",
				))
				->add('maxMessage', 'text', array(
					'label' => "max Message",
				))
				->add('exactMessage', 'text', array(
					'label' => "exact Message",
				))
			;
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'config_constraint_length';
		}
	}
