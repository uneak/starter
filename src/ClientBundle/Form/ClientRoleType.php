<?php

	namespace ClientBundle\Form;

	use ClientBundle\Entity\ClientRole;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ClientRoleType extends AbstractType {
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

				->add('roles', 'choice_select2', array(
					'label' => "permissions",
					'choices'   => array(
						ClientRole::CONTACT_INFO => 'Information de contact',
						ClientRole::DELETE => 'Supression',
						ClientRole::EXECUTE => 'Action',
						ClientRole::EXPORT => 'Export',
						ClientRole::READ => 'lecture',
						ClientRole::UPDATE => 'Mise a jour',
						ClientRole::WRITE => 'Création',
					),
					'multiple' => true
				))


				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'ClientBundle\Entity\ClientRole',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'clientbundle_client';
		}
	}
