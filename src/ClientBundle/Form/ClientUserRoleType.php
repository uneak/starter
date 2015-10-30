<?php

	namespace ClientBundle\Form;

	use ClientBundle\Entity\ClientUserRole;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ClientUserRoleType extends AbstractType {
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
						ClientUserRole::CONTACT_INFO => 'Information de contact',
						ClientUserRole::DELETE => 'Supression',
						ClientUserRole::EXECUTE => 'Action',
						ClientUserRole::EXPORT => 'Export',
						ClientUserRole::READ => 'lecture',
						ClientUserRole::UPDATE => 'Mise a jour',
						ClientUserRole::WRITE => 'Création',
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
				'data_class' => 'ClientBundle\Entity\ClientUserRole',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'clientbundle_client';
		}
	}
