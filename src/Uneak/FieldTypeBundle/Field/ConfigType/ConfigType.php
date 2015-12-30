<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	abstract class ConfigType extends AssetsFormType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
                ->add('label', 'text', array(
                    'label' => "Label",
                ))
				;
		}

	}
