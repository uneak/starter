<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class MainInterfaceTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder

				->add('porto_admin_theme_custom_css')
                ->add('modernizr_js')
                ->add('jquery_browser_mobile_js')
                ->add('bootstrap_js')
//
                ->add('porto_admin_theme_base_js')





//                ->add('porto_admin_theme_lock_screen_js')
//                ->add('porto_admin_theme_panels_js')
//                ->add('porto_admin_theme_form_to_object_js')
//                ->add('porto_admin_theme_loading_overlay_js')
//                ->add('porto_admin_theme_map_builder_js')
//                ->add('porto_admin_theme_datatable_config_js')
//                ->add('porto_admin_theme_notifications_config_js')
//
//
//
//
//                ->add('porto_admin_theme_init_popover_js')
//                ->add('porto_admin_theme_init_tooltip_js')
//                ->add('porto_admin_theme_init_ios_switcher___js')
//                ->add('porto_admin_theme_init_codemirror_js')
//                ->add('porto_admin_theme_init_color_picker_js')
//                ->add('porto_admin_theme_init_date_picker_js')
//                ->add('porto_admin_theme_init_scroll_to_top_js')
//                ->add('porto_admin_theme_init_ios_switcher_js')
//                ->add('porto_admin_theme_init_markdown_js')
//                ->add('porto_admin_theme_init_masked_input_js')
//                ->add('porto_admin_theme_init_max_length_js')
//                ->add('porto_admin_theme_init_multi_select_js')
//                ->add('porto_admin_theme_init_placeholder_js')
//                ->add('porto_admin_theme_init_select2_js')
//                ->add('porto_admin_theme_init_spinner_js')
//                ->add('porto_admin_theme_init_summer_note_js')
//                ->add('porto_admin_theme_init_textarea_autosize_js')
//                ->add('porto_admin_theme_init_time_picker_js')
//                ->add('porto_admin_theme_init_mail_box_js')
//                ->add('porto_admin_theme_init_animate_js')
//                ->add('porto_admin_theme_init_carousel_js')
//                ->add('porto_admin_theme_init_chart_circular_js')
//                ->add('porto_admin_theme_init_lightbox_js')
//                ->add('porto_admin_theme_init_progress_js')
//                ->add('porto_admin_theme_init_portlets_js')
//                ->add('porto_admin_theme_init_slider_js')
//                ->add('porto_admin_theme_init_toggle_js')
//                ->add('porto_admin_theme_init_widget_todo_js')
//                ->add('porto_admin_theme_init_widget_toggle_js')
//                ->add('porto_admin_theme_init_word_rotate_js')



            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['left_sidebar'] = $block->getLeftSidebar();
			$options['right_sidebar'] = $block->getRightSidebar();
			$options['header'] = $block->getHeader();
			$options['content'] = $block->getContent();
			$options['title'] = $block->getTitle();
			$options['left_sidebar_collapsed'] = $block->isLeftSidebarCollapsed();
			$options['layout_style'] = $block->getLayoutStyle();
			$options['background_color'] = $block->getBackgroundColor();
			$options['header_color'] = 'header-'.$block->getHeaderColor();
			$options['left_sidebar_size'] = 'sidebar-left-'.$block->getSidebarLeftSize();

		}

		public function getRenderTemplate() {
			return 'layout_main_interface_template';
		}

	}