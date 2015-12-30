<?php

	namespace Uneak\FieldTypeBundle\Form;

	use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\FieldTypeBundle\Field\FieldTypesManager;

    class FieldTypeSelectorType extends AbstractType {

		/**
		 * @var FieldTypesManager
		 */
		private $fieldTypesManager;

		public function __construct(FieldTypesManager $fieldTypesManager) {
			$this->fieldTypesManager = $fieldTypesManager;
		}


        public function setDefaultOptions(OptionsResolverInterface $resolver) {
            $choices = array();
            $fieldTypes = $this->fieldTypesManager->getFieldTypes();
            foreach ($fieldTypes as $fieldType) {
                $choices[$fieldType['alias_field']] = $fieldType['label'];
            }

            $resolver->setDefaults(array(
                'choices' => $choices,
            ));
        }


        public function getParent() {
            return 'choice';
        }

		/**
		 * @return string
		 */
		public function getName() {
			return 'fieldtypes_selector';
		}
	}