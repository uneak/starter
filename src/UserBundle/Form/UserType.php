<?php

	namespace UserBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class UserType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('username', null, array(
					'label' => "Nom d'utilisateur",
				))

				->add('firstName', null, array(
					'label' => "Prénom",
				))
				->add('lastName', null, array(
					'label' => "Nom",
				))
				->add('imageFile', 'vich_file', array(
						'label'         => "Photo",
						'required'      => false,
						'allow_delete'  => true, // not mandatory, default is true
						'download_link' => true, // not mandatory, default is true
					)
				)

				->add('email', null, array(
					'label' => "Email",
				))

				->add('enabled', null, array(
					'label' => "Activé",
					'required'      => false,
				));

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
			return 'userbundle_user';
		}
	}
