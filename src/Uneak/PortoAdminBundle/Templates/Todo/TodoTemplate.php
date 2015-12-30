<?php

	namespace Uneak\PortoAdminBundle\Templates\Todo;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class TodoTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_widget_todo_js')
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['slug'] = $block->getSlug();
			$options['content'] = $block->getContent();
			$options['menu'] = $block->getMenu();

		}

		public function getRenderTemplate() {
			return 'block_todo_template';
		}

	}