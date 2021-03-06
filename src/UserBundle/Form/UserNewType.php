<?php

	namespace UserBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class UserNewType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
                ->add('gender', 'gender', array(
                    'label' => "Genre",
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

                ->add('username', null, array(
                    'label' => "Nom d'utilisateur",
                    'attr' => array(
                        'help'=> 'HELLoooo',
                    )

                ))

                ->add('plain_password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Les mots de passe doivent correspondre',
                    'options' => array('required' => true),
                    'first_options'  => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Mot de passe (validation)'),
                ))

                ->add('enabled', null, array(
					'label' => "Activé",
					'required'      => true,
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
