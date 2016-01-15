<?php

	namespace Uneak\FieldDataBundle\Form;

	use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\FieldDataBundle\FieldData\FieldDataHelper;

    class FieldDataSelectorType extends AbstractType {

        public function setDefaultOptions(OptionsResolverInterface $resolver) {
            $choices = array();
            $alias = FieldDataHelper::ALIAS();
            foreach ($alias as $type => $label) {
                $choices[$type] = $label;
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