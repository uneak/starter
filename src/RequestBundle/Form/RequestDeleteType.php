<?php

	namespace RequestBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Symfony\Component\Validator\Constraints\IsTrue;
	use Symfony\Component\Validator\Constraints\IsTrueValidator;

	class RequestDeleteType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
                ->add('confirm', 'checkbox', array(
					'label' => "Confirmer la suppression",
					'required' => true,
					'constraints' => array(new IsTrue())
				))
			;

		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'requestbundle_delete_user';
		}
	}
