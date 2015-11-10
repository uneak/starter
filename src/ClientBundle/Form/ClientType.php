<?php

	namespace ClientBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ClientType extends AbstractType {
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

				->add('slug', null, array(
						'label' => 'code',
						'required' => false,
					)
				)

				->add('description', null, array(
						'label' => 'Description',
						'required' => false,
					)
				)

				->add('imageFile', 'vich_file', array(
						'label'         => "Photo",
						'required'      => false,
						'allow_delete'  => true, // not mandatory, default is true
						'download_link' => true, // not mandatory, default is true
					)
				)

				->add('client_users', 'uneak_collection', array(
					'type' => new ClientUserType(),
					'required' => false,
					'label' => "Utilisateurs",
					'allow_add' => true,
					'allow_delete' => true,
					'add_button_text' => 'Ajouter',
					'delete_button_text' => 'Supprimer',
					'by_reference' => false,
				))


				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'ClientBundle\Entity\Client',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'clientbundle_client';
		}
	}
