<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\FormEvent;
	use Symfony\Component\Form\FormEvents;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Validator\Constraints\Collection;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\FormsManagerBundle\Forms\AssetsFormType;

	abstract class Select2Type extends AssetsFormType {

		public function buildForm(FormBuilderInterface $builder, array $options) {


			$builder->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) use ($options) {

				if (!isset($options['options']['tags'])) {
					return;
				}

				$em = $options['em'];
				$class = $options['class'];
				$metaData = $em->getClassMetadata($class);
				$accessor = PropertyAccess::createPropertyAccessor();

				$property = $options['property'];
				$identifier = $metaData->getIdentifier()[0];

				$oData = $event->getData();
				$array = explode(",", $oData[0]);

				$rData = array();

				foreach ($array as $eTag) {
					$tag = $em->getRepository($class)->findOneBy(array($property => $eTag));
					if (!$tag) {
						$tag = $metaData->getReflectionClass()->newInstance();
						$accessor->setValue($tag, $property, $eTag);
						$em->persist($tag);
						$em->flush();
					}
					array_push($rData, $accessor->getValue($tag, $identifier));
				}

				$event->setData($rData);
			});
		}


		public function buildView(FormView $view, FormInterface $form, array $options) {

			$view->vars['options'] = $options['options'];
			if ($options['empty_value']) {
				$view->vars['options']['placeholder'] = $options['empty_value'];
				$view->vars['empty_value'] = "";
			}

            if (isset($options['required'])) {
                $view->vars['options']['allowClear'] = !$options['required'];
            }

			if (isset($view->vars['options']['tags'])) {

				$accessor = PropertyAccess::createPropertyAccessor();
				$property = $options['property'];
				$tags = $view->vars["data"];
				$rData = array();
				foreach ($tags as $tag) {
					array_push($rData, $accessor->getValue($tag, $property));
				}
				$view->vars["value"] = join(",", $rData);


				$view->vars['options']['tags'] = array();
				foreach ($view->vars['choices'] as $choice) {
					$view->vars['options']['tags'][] = $choice->label;
				}

				$view->vars['input'] = "hidden_widget";
			} else {
				$view->vars['input'] = "choice_widget";
			}

		}


		public function setDefaultOptions(OptionsResolverInterface $resolver) {

			$resolver->setDefaults(array(
				'options' => array(),
			));

			$resolver->setDefined(
				array(
					'options',
				)
			);
		}





		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

			$builder
				->add("select2_js")
				->add("select2_bootstrap_css")

				->add("script_select2", 'internaljs', array(
					"template"     => "select2_script_template",
					"parameters" => array('item' => $parameters),
					"dependencies" => array("select2_js"),
				));

			if (isset($parameters->vars["options"]["language"])) {

				$builder->add("select2_language_js", 'externaljs', array(
					"src"          => "vendor/select2/select2_locale_" . $parameters->vars["options"]["language"] . ".js",
					"dependencies" => array("select2_js"),
					"charset"      => "UTF-8"
				));

			}

		}


		public function getTheme() {
			return "form_select2_theme_template";
		}

	}
