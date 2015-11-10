<?php

	namespace ProspectBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ProspectType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('group', null, array(
						'label' => 'Group',
						'required' => true,
					)
				)

				->add('source', null, array(
						'label' => 'Source',
						'required' => false,
					)
				)

				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'ProspectBundle\Entity\Prospect',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'prospectbundle_prospect';
		}
	}
