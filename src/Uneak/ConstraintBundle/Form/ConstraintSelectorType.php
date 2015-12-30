<?php

	namespace Uneak\ConstraintBundle\Form;

	use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\ConstraintBundle\Constraint\ConstraintsManager;
    use Uneak\FieldTypeBundle\Field\ConstraintManager;

    class ConstraintSelectorType extends AbstractType {

		/**
		 * @var ConstraintsManager
		 */
		private $constraintsManager;

		public function __construct(ConstraintsManager $constraintsManager) {
			$this->constraintsManager = $constraintsManager;
		}


        public function setDefaultOptions(OptionsResolverInterface $resolver) {
            $choices = array();
            $constraints = $this->constraintsManager->getConstraints();
            foreach ($constraints as $constraint) {
                $choices[$constraint['alias']] = $constraint['label'];
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
			return 'constraints_selector';
		}
	}