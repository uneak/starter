<?php

	namespace OAuthServerBundle\Form;


    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class OAuthServerType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
            $builder
                ->add('label', null, array(
                        'label' => 'Nom',
                        'required' => true,
                    )
                )
                ->add('description', null, array(
                        'label' => 'Description',
                        'required' => false,
                    )
                )

//                ->add('imageFile', 'vich_file', array(
//                        'label'         => "Photo",
//                        'required'      => false,
//                        'allow_delete'  => true, // not mandatory, default is true
//                        'download_link' => true, // not mandatory, default is true
//                    )
//                )

//                ->add('randomId', null, array(
//                        'label' => 'Application ID',
//                        'required' => true,
//                    )
//                )
//                ->add('secret', null, array(
//                        'label' => 'Application Secret',
//                        'required' => true,
//                    )
//                )
                ->add('redirect_uris', 'uneak_collection', array(
                    'type' => 'url',
                    'required' => false,
                    'label' => "Redirection",
                    'allow_add' => true,
                    'allow_delete' => true,
                    'add_button_text' => 'Add',
                    'delete_button_text' => 'Remove',
                ))

                ->add('allowed_grant_types', 'uneak_collection', array(
                    'type' => 'choice',
                    'options' => array(
                        'choices' => array(
                            'authorization_code' => 'authorization_code',
                            'client_credentials' => 'client_credentials',
                            'allow_implicit' => 'allow_implicit',
                            'refresh-token' => 'refresh-token',
                            'token' => 'token',
                            'password' => 'password',
                        ),
                        'required' => true,
                        'empty_value' => 'Sélectionnez votre grant type',
                        'empty_data' => null,
                    ),
                    'required' => false,
                    'label' => "Autorisation",
                    'allow_add' => true,
                    'allow_delete' => true,
                    'add_button_text' => 'Add',
                    'delete_button_text' => 'Remove',

                ))
            ;



		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'OauthServerBundle\Entity\Client',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'ouathserverbundle_client';
		}
	}
