<?php

	namespace Uneak\FieldDataBundle\Form;

	use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\FieldDataBundle\FieldData\FieldDatasManager;

	class FieldDataSelectorType extends AbstractType {

		/**
		 * @var FieldDatasManager
		 */
		private $fieldDatasManager;

		public function __construct(FieldDatasManager $fieldDatasManager) {
			$this->fieldDatasManager = $fieldDatasManager;
		}


        public function setDefaultOptions(OptionsResolverInterface $resolver) {
            $choices = array();
            $fieldDatas = $this->fieldDatasManager->getFieldDatas();
            foreach ($fieldDatas as $fieldData) {
                $choices[$fieldData['alias']] = $fieldData['label'];
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
			return 'fielddatas_selector';
		}
	}