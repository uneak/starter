<?php

	namespace Uneak\ConstraintBundle\Constraint\ConfigType;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class BlankConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
			$builder
				->add('message', 'text', array(
					'label' => "Message",
					'attr' => array(
						'help_text' => "This is the message that will be shown if the value is not blank.",
					)
				))
			;
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'config_constraint_blank';
		}
	}
