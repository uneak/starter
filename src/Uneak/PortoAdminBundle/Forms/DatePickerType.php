<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	class DatePickerType extends AssetsFormType {

		private $_formatConvertRules = array(
			// year
			'yyyy'  => 'YYYY', 'yy' => 'YY', 'y' => 'YYYY',
			// month
			// 'MMMM'=>'MMMM', 'MMM'=>'MMM', 'MM'=>'MM',
			// day
			'dd'    => 'DD', 'd' => 'D',
			// hour
			// 'HH'=>'HH', 'H'=>'H', 'h'=>'h', 'hh'=>'hh',
			// am/pm
			// 'a' => 'a',
			// minute
			// 'mm'=>'mm', 'm'=>'m',
			// second
			// 'ss'=>'ss', 's'=>'s',
			// day of week
			'EE'    => 'ddd', 'EEEEEE' => 'dd',
			// timezone
			'ZZZZZ' => 'Z', 'ZZZ' => 'ZZ',
			// letter 'T'
			'\'T\'' => 'T',
		);


		private static $defaultFormat = "dd/MM/yyyy HH:mm";


		public function buildView(FormView $view, FormInterface $form, array $options) {

			$options['options']["format"] = strtr($options['format'], $this->_formatConvertRules);


			//			if (!isset($pickerOptions['language'])) {
			//				$pickerOptions['language'] = \Locale::getDefault();
			//			}

			//			if(!isset($options['format'])) {
			//				$options['format'] = self::$defaultFormat;
			//			}
			//
			//			if ($options['formatter'] == 'php'){
			//				$options['format'] = self::convertIntlFormaterToMalot( $options['format'] );
			//			}


			//			if ($options['html5'] && self::HTML5_FORMAT === $options['format']) {
			//				$view->vars['type'] = 'datetime';
			//			}

			//			$view->vars['markup'] = $options['markup'];

			$view->vars['widget'] = "single_text";
			$view->vars['options'] = $options['options'];
		}


		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefined(
				array(
					'options',
				)
			);
			$resolver->setDefaults(array(
				'widget'  => 'single_text',
				'format'  => self::$defaultFormat,
//				'options' => array(),
			));
		}


		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

			$builder
				->add("moment_js")
				->add("datepicker_js")
				->add("datetimepicker_js")

				->add("datetimepicker_css")


				->add("script_datepicker_js", 'internaljs', array(
					"template"     => "date_picker_script_template",
					"parameters" => array('item' => $parameters),
				));

			if (isset($parameters->vars["options"]["language"])) {

				$builder->add("moment_language_js", 'externaljs', array(
					"src"          => "vendor/moment/locale/" . $parameters->vars["options"]["language"] . ".js",
					"dependencies" => array("moment_js"),
					"charset"      => "UTF-8"
				));

				$builder->add("datetimepicker_js", null, array(
					"dependencies" => array("moment_language_js")
				));

			} else {

				$builder->add("datetimepicker_js", null, array(
					"dependencies" => array("moment_js")
				));

			}

		}

		public function getTheme() {
			return "form_date_picker_theme_template";
		}

		public function getParent() {
			return 'datetime';
		}

		public function getName() {
			return 'uneak_date_picker';
		}

	}
