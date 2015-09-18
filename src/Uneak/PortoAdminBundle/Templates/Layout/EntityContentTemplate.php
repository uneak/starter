<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityContentTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
            $builder
                ->add('porto_admin_entity_css')
                ->add("porto_admin_scrollable_script", "internaljs", array(
                    "template"   => 'porto_admin_scrollable_script_template',
                    "parameters" => array(
                        'uniqid' => $parameters->getUniqid()
                    ),
                    "dependencies" => array("nanoscroller_js")
                ));
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['subtitle'] = $block->getSubtitle();

			$widgets = $block->getWidgets();
			$options['widgets'] = $widgets;

            $options['actions'] = $block->getActions();
			$options['body'] = $block->getBody();
		}

		public function getRenderTemplate() {
			return 'layout_entity_content_template';
		}

	}