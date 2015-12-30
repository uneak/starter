<?php

	namespace Uneak\PortoAdminBundle\Templates\Todo;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class TodosTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_init_widget_todo_js')
				->add('todo_block_script', 'internaljs', array(
					'template'   => 'todo_script_template',
					'parameters' => array('item' => $parameters, 'fieldset' => $parameters->getFieldset())
				));
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['todos'] = $block->getTodos();
			$options['fields_group'] = $block->getFieldset();
		}

		public function getRenderTemplate() {
			return 'block_todos_template';
		}

	}