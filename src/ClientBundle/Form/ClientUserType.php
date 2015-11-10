<?php

	namespace ClientBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ClientUserType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('user', 'entity_select2', array(
						'label' => 'Utilisateur',
						'class' => 'UserBundle\Entity\User',
//						'property' => 'label',

						'options' => array(
							'placeholder' => "Sectionnez l'utilisateur",
							'allowClear' => true,
							'language' => 'fr'
						),
						'required' => true,
					)
				)

				->add('role', 'entity_select2', array(
					'label' => "Role",
					'class' => 'ClientBundle\Entity\ClientRole',
					'property' => 'label',

					'options' => array(
						'placeholder' => "Sectionnez le role",
						'allowClear' => true,
						'maximumSelectionLength' => 2,
						'language' => 'fr'
					),
					'required' => true,

				))


				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'ClientBundle\Entity\ClientUser',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'clientbundle_client_role';
		}
	}
