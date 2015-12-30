<?php

	namespace Uneak\FieldTypeBundle\Field\ConfigType;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use IntlDateFormatter;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class DateConfigType extends ConfigType {

		/**
		 * @param FormBuilderInterface $builder
		 * @param array                $options
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
			parent::buildForm($builder, $options);

			$builder

				->add('days', null, array(
					'empty_data'  => null,
				))

				->add('months', null, array(
					'empty_data'  => null,
				))

				->add('years', null, array(
					'empty_data'  => null,
				))

				->add('input', 'choice', array(
					'choices' => array(
						'string' => 'string (e.g. 2011-06-05)',
						'datetime' => 'datetime (a DateTime object)',
						'array' => 'array (e.g. array(\'year\' => 2011, \'month\' => 06, \'day\' => 05))',
						'timestamp' => 'timestamp (e.g. 1307232000)',
					),
				))

				->add('widget', 'choice', array(
					'choices' => array(
						'choice' => 'choice : renders three select inputs. The order of the selects is defined in the format option.',
						'text' => 'text : renders a three field input of type text (month, day, year).',
						'single_text' => 'single_text : renders a single input of type date. User\'s input is validated based on the format option.',
					),
				))

				->add('format', 'choice', array(
					'choices' => array(
						IntlDateFormatter::FULL => 'IntlDateFormatter::FULL',
						IntlDateFormatter::LONG => 'IntlDateFormatter::LONG',
						IntlDateFormatter::MEDIUM => 'IntlDateFormatter::MEDIUM',
						IntlDateFormatter::SHORT => 'IntlDateFormatter::SHORT',
					),
				))

				->add('model_timezone', null, array(
					'empty_data'  => null,
				))

				->add('view_timezone', null, array(
					'empty_data'  => null,
				))

				->add('empty_value', null, array(
					'empty_data'  => null,
				))

				;
		}




		/**
		 * @return string
		 */
		public function getName() {
			return 'config_uneak_date_picker';
		}
	}
