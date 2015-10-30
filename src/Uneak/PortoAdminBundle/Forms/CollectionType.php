<?php

	namespace Uneak\PortoAdminBundle\Forms;

	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
    use Symfony\Component\OptionsResolver\Options;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Symfony\Component\Validator\Constraints\Collection;
    use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\FormsManagerBundle\Forms\AssetsFormType;

    class CollectionType extends AssetsFormType {



		public function buildView(FormView $view, FormInterface $form, array $options) {
			parent::buildView($view, $form, $options);

            $view->vars = array_replace(
                $view->vars,
                array(
                    'allow_add'          => $options['allow_add'],
                    'allow_delete'       => $options['allow_delete'],
                    'add_button_text'    => $options['add_button_text'],
                    'delete_button_text' => $options['delete_button_text'],
                    'prototype_name'     => $options['prototype_name']
                )
            );
            if ($form->getConfig()->hasAttribute('prototype')) {
                $view->vars['prototype'] = $form->getConfig()->getAttribute('prototype')->createView($view);
            }

		}


        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $optionsNormalizer = function (Options $options, $value) {
                // @codeCoverageIgnoreStart
                $value['block_name'] = 'entry';
                return $value;
                // @codeCoverageIgnoreEnd
            };

            $resolver->setDefaults(array(
                'allow_add'          => false,
                'allow_delete'       => false,
                'prototype'          => true,
                'prototype_name'     => '__name__',
                'type'               => 'text',
                'add_button_text'    => 'Add',
                'delete_button_text' => 'Delete',
                'options'            => array(),
            ));
            $resolver->setNormalizer('options', $optionsNormalizer);
        }



        public function buildAsset(AssetsBuilderManager $builder, $parameters) {

            $builder
                ->add("uneak_collection_script", "internaljs", array(
                    "template"   => 'form_collection_script_template',
                    "parameters" => array(
                        "vars" => $parameters->vars,
                        "prototype" => $parameters->vars['prototype'],
                        "uniqid" => $parameters->vars['id']
                    ),
                ));
            ;

        }

		public function getTheme() {
			return "form_collection_theme_template";
		}

		public function getParent() {
			return 'collection';
		}

		public function getName() {
			return 'uneak_collection';
		}

	}
