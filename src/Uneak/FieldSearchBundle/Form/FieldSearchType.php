<?php

	namespace Uneak\FieldSearchBundle\Form;

	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\EntityRepository;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\NotBlank;


	class FieldSearchType extends AbstractType {

		/**
		 * @var
		 */
		private $fields;

		public function __construct(array $fields) {
			$this->fields = $fields;
		}

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			foreach ($this->fields as $field) {
                foreach ($field['fieldsearch'] as $fieldSearch) {
                    $builder->add($field['name'], $fieldSearch['alias_search'], array('label' => $field['title']));
                }
			}
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'fieldsearchs';
		}
	}
