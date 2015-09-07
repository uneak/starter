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
//                ->add('porto_admin_theme_codemirror_js')
//                ->add('porto_admin_theme_color_picker_js')
//                ->add('porto_admin_theme_date_picker_js')
//                ->add('porto_admin_theme_ios_switcher_js')
//                ->add('porto_admin_theme_markdown_js')
//                ->add('porto_admin_theme_masked_input_js')
//                ->add('porto_admin_theme_max_length_js')
//                ->add('porto_admin_theme_multi_select_js')
//                ->add('porto_admin_theme_select2_js')
//                ->add('porto_admin_theme_spinner_js')
//                ->add('porto_admin_theme_summer_note_js')
//                ->add('porto_admin_theme_textarea_autosize_js')
//                ->add('porto_admin_theme_time_picker_js')
//                ->add('porto_admin_theme_map_builder_js')
//                ->add('porto_admin_theme_animate_js')
//                ->add('porto_admin_theme_carousel_js')
//                ->add('porto_admin_theme_chart_circular_js')
//                ->add('porto_admin_theme_lightbox_js')
//                ->add('porto_admin_theme_portlets_js')
//                ->add('porto_admin_theme_scrollable_js')
//                ->add('porto_admin_theme_slider_js')
//                ->add('porto_admin_theme_toggle_js')
//                ->add('porto_admin_theme_widget_todo_js')
//                ->add('porto_admin_theme_widget_toggle_js')
//                ->add('porto_admin_theme_word_rotate_js')
//                ->add('porto_admin_theme_datatable_config_js')
//                ->add('porto_admin_theme_notifications_config_js')


                ->add('porto_admin_theme_init_popover_js')
                ->add('porto_admin_theme_init_tooltip_js')
                ->add('porto_admin_theme_init_sidebar_widget_js')
                ->add('porto_admin_theme_init_ios_switcher_js')
                ->add('porto_admin_theme_init_codemirror_js')
                ->add('porto_admin_theme_init_color_picker_js')
                ->add('porto_admin_theme_init_date_picker_js')

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