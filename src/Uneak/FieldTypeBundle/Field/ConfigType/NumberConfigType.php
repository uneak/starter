<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class NumberConfigType extends ConfigType {
		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);
			$builder

				->add('precision', "integer", array(
					'data'  => 3,
				))

				->add('rounding_mode', 'choice', array(
					'choices' => array(
						IntegerToLocalizedStringTransformer::ROUND_DOWN => 'Mode pour arrondir jusqu\'à zéro.',
						IntegerToLocalizedStringTransformer::ROUND_FLOOR => 'Mode pour arrondir jusqu\'à l\'infini négatif.',
						IntegerToLocalizedStringTransformer::ROUND_UP => 'Mode pour arrondir en partant de zéro.',
						IntegerToLocalizedStringTransformer::ROUND_CEILING => 'Mode pour arrondir jusqu\'à l\'infini positif.',
						IntegerToLocalizedStringTransformer::ROUND_HALFDOWN => 'Mode pour arrondir au « voisin le plus proche ». Si les deux voisins sont équidistants, alors c\'est arrondi au voisin inférieur.',
						IntegerToLocalizedStringTransformer::ROUND_HALFEVEN => 'Mode pour arrondir au « voisin le plus proche ». Si les deux voisins sont équidistants, alors c\'est arrondi au voisin pair.',
						IntegerToLocalizedStringTransformer::ROUND_HALFUP => 'Mode pour arrondir au « voisin le plus proche ». Si les deux voisins sont équidistants, alors c\'est arrondi au voisin supérieur.',
					),
				))

				->add('grouping', "checkbox", array(
					"value" => false,
				))


				;
		}



		/**
		 * @return string
		 */
		public function getName() {
			return 'config_number';
		}
	}
