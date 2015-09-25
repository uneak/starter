<?php

	namespace UserBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;
	use UserBundle\Entity\User;

	class UserAccountType extends AssetsFormType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
                ->add('stateProfile', 'choice', array(
                    'label' => "Etat",
					'choices'   => array(
						User::STATE_PROFILE_PENDING => 'En attente',
						User::STATE_PROFILE_ACCEPT => 'Accepter',
						User::STATE_PROFILE_REFUSED => 'Refuser',
					),
					'required'  => true,
                ))

				->add('role', 'choice', array(
					'label' => "Role",
					'choices'   => array(
						'ROLE_ADMIN' => 'Utilisateur',
						'ROLE_SUPER_ADMIN' => 'Super administrateur',
					),
					'mapped' => false,
					'required'  => true,
				))
				;
		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'UserBundle\Entity\User',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'userbundle_user_account';
		}
	}
