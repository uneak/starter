<?php

	namespace ProspectGroupFieldBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	class ProspectGroupFieldType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
                ->add('group', null, array(
                        'label' => 'Groupe',
                        'required' => true,
                    )
                )
                ->add('label', null, array(
                        'label' => 'Titre',
                        'required' => true,
                    )
                )
                ->add('slug', null, array(
                        'label' => 'Slug',
                        'required' => false,
                    )
                )
                ->add('type', 'fielddatas_selector', array(
                        'label' => 'Type de donnée',
                        'required' => true,
                    )
                )
                ->add('fieldType', 'fieldtypes_selector', array(
                        'label' => 'Champ de formulaire',
                        'required' => true,
                    )
                )
				;


		}


		/**
		 * @param OptionsResolverInterface $resolver
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'data_class' => 'Uneak\FieldBundle\Entity\Field',
			));
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'fieldbundle_field';
		}
	}
