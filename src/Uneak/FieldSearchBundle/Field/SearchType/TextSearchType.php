<?php

	namespace Uneak\FieldSearchBundle\Field\SearchType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class TextSearchType extends SearchType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
            $builder
                ->add('like', 'text', array(
                    'label' => "Texte",
                    'attr' => array(
                        'help_text' => "utiliser le caractère '%' comme jocker",
                    )
                ))
            ;
		}



		/**
		 * @return string
		 */
		public function getName() {
			return 'search_text';
		}
	}
