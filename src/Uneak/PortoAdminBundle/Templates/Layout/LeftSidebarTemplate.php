<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class LeftSidebarTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_bootstrap_toggle_js')
				->add('porto_admin_theme_scrollable_js')

//                ->add("porto_admin_sidebar_toggle_script", "internaljs", array(
//                    "template"   => 'porto_admin_sidebar_toggle_script_template',
//                    "parameters" => array(
//                        'uniqid' => $parameters->getUniqid()
//                    )
//                ))

//                ->add("porto_admin_scrollable_script", "internaljs", array(
//                    "template"   => 'porto_admin_scrollable_script_template',
//                    "parameters" => array(
//                        'uniqid' => $parameters->getUniqid()
//                    ),
//                    "dependencies" => array("nanoscroller_js")
//                ))

			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
            $options['uniqid'] = $block->getUniqid();
			$options['title'] = $block->getTitle();
            $options['widgets'] = $block->getWidgets();
		}

		public function getRenderTemplate() {
			return 'layout_left_sidebar_template';
		}

	}