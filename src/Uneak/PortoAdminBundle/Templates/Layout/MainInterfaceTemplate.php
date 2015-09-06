<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class MainInterfaceTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_custom_css')
                ->add('modernizr_js')
                ->add('jquery_browser_mobile_js')
                ->add('bootstrap_js')
                ->add('nanoscroller_js')
//                ->add('jquery_placeholder_js')

//
                ->add('porto_admin_theme_base_js')
                ->add('porto_admin_theme_scroll_to_top_js')
                ->add('porto_admin_theme_bootstrap_toggle_js')

//                ->add('porto_admin_theme_mail_box_js')
//                ->add('porto_admin_theme_lock_screen_js')
//                ->add('porto_admin_theme_panels_js')
//                ->add('porto_admin_theme_form_to_object_js')
//                ->add('porto_admin_theme_loading_overlay_js')

                ->add('porto_admin_theme_custom_js')
                ->add('porto_admin_theme_init_js')
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
			$options['left_sidebar'] = $block->getLeftSidebar();
			$options['right_sidebar'] = $block->getRightSidebar();
			$options['header'] = $block->getHeader();
			$options['content'] = $block->getContent();
			$options['title'] = $block->getTitle();
		}

		public function getRenderTemplate() {
			return 'layout_main_interface_template';
		}

	}