<?php

	namespace GroupFieldBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class GroupFieldType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('group', null, array(
						'label' => 'Groupe',
						'required' => true,
					)
				)

				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'GroupFieldBundle\Entity\GroupField',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'fieldbundle_field';
		}
	}
