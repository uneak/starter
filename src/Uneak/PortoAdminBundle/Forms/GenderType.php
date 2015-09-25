<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\FormsManagerBundle\Forms\AssetsFormType;

    class GenderType extends AssetsFormType {

		public function setDefaultOptions(OptionsResolverInterface $resolver) {
			$resolver->setDefaults(array(
				'choices' => array(
					'homme' => 'Homme',
					'femme' => 'Femme',
				)
			));
		}

		public function buildView(FormView $view, FormInterface $form, array $options) {
			parent::buildView($view, $form, $options);
			if (array_key_exists('choices', $options)) {
				$view->vars['choicess'] = $options['choices'];
			}
		}


        public function buildAsset(AssetsBuilderManager $builder, $parameters) {

            $builder
                ->add("select3_js", "externaljs", array(
                    "src" => "/vendor/select2/select2.js"
                ))
            ;

        }

		public function getTheme() {
			return "form_gender_theme_template";
		}

		public function getParent() {
			return 'choice';
		}

		public function getName() {
			return 'gender';
		}

	}
