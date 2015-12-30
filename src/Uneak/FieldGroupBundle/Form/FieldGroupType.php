<?php

	namespace Uneak\FieldGroupBundle\Form;

	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\EntityRepository;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Symfony\Component\Validator\Constraints\Length;
	use Symfony\Component\Validator\Constraints\NotBlank;


	class FieldGroupType extends AbstractType {

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
				$builder->add($field['slug'], $field['type'], $field['options']);
			}
		}


		/**
		 * @return string
		 */
		public function getName() {
			return 'fieldgroup';
		}
	}
