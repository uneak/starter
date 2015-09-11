<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityContentTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
            $builder
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
			$options['uniqid'] = $block->getUniqid();
			$options['header'] = $block->getHeader();
			$options['body'] = $block->getBody();
		}

		public function getRenderTemplate() {
			return 'layout_entity_content_template';
		}

	}