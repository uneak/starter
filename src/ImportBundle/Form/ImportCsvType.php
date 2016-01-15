<?php

	namespace ImportBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	use Symfony\Component\Validator\Constraints\File;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\NotBlank;

	class ImportCsvType extends AbstractType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('group', 'entity', array(
						'label' => 'Groupe',
						'class' => 'Uneak\FieldGroupBundle\Entity\FieldGroup',
						'choice_label' => 'label',
						'required' => true,
					)
				)
				->add('file', 'file', array(
					'label' => 'Fichier CSV',
					'constraints' => new File(array(
						'mimeTypes' => array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv'),
						'mimeTypesMessage' => "Please upload a valid CSV",
					)),
					'required' => false,
				))
				->add('content', 'textarea', array(
					'label' => 'Contenu CSV',
				))
				->add('rowDelimiter', 'text', array(
					'label' => 'Séparateur de colonne',
					'data' => ';',
					'constraints' => array(
						new NotBlank(),
						new Length(array('min' => 1, 'max' => 1)),
					)
				))
				->add('delimiter', 'text', array(
					'label' => 'Séparateur',
					'data' => ';',
					'constraints' => array(
						new NotBlank(),
						new Length(array('min' => 1, 'max' => 1)),
					)
				))

				;


		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'importbundle_import_csv';
		}
	}
