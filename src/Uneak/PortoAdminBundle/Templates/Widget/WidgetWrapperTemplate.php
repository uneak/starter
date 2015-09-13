<?php

	namespace Uneak\PortoAdminBundle\Templates\Widget;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class WidgetWrapperTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
            $builder

                ->add("porto_admin_widget_wrapper_script", "internaljs", array(
                    "template"   => 'porto_admin_sidebar_widget_wrapper_script_template',
                    "parameters" => array(
                        'uniqid' => $parameters->getUniqid()
                    ),
                    "dependencies" => array("porto_admin_theme_init_widget_wrapper_js")
                ));
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['title'] = $block->getTitle();
			$options['toggle'] = $block->isToggle();
            $options['widgets'] = $block->getBlocks("widgets");

		}

		public function getRenderTemplate() {
			return 'block_widget_wrapper_template';
		}

	}