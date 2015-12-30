<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;

	class AttributeType extends AbstractType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('key', null, array(
					'label'    => 'Clé',
					'required' => true,
				))
				->add('value', null, array(
					'label'    => 'Valeur',
					'required' => true,
				));
		}

		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
		}

		/**
		 * @return string
		 */
		public function getName() {
			return 'uneak_attribute';
		}

	}
