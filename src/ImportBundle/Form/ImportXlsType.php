<?php

	namespace ImportBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;

	use Symfony\Component\Validator\Constraints\File;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\NotBlank;

	class ImportXlsType extends AbstractType {
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
					'label' => 'Fichier Excel',
					'constraints' => new File(array(

						'mimeTypes' => array(
							'application/vnd.ms-excel',
							'application/msexcel',
							'application/x-msexcel',
							'application/x-ms-excel',
							'application/x-excel',
							'application/x-dos_ms_excel',
							'application/xls',
							'application/x-xls',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
						),
						'mimeTypesMessage' => "Please upload a valid Excel file",
					)),
					'required' => false,
				))
				->add('headerRowNumber', 'integer', array(
					'label' => "Numéro de la ligne de l'entete",
					'data' => 0,
				))
				->add('activeSheet', 'integer', array(
					'label' => "Sheet active",
					'data' => 0,
				))
				;


		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'importbundle_import_xls';
		}
	}
