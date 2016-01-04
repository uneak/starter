<?php

	namespace Uneak\PortoAdminBundle\Templates\Datatable;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class DatatableTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

			$options = array();
			$options['uniqid'] = $parameters->getUniqid();
			$options['columns'] = $parameters->getColumns();
			$options['display_length'] = $parameters->getIDisplayLength();
			$options['state_save'] = $parameters->isStateSave();
			$options['processing'] = $parameters->isProcessing();
			$options['server_side'] = $parameters->isServerSide();
			$options['ajax'] = $parameters->getAjax();
			$options['query'] = $parameters->getQuery();
			$options['search_input'] = $parameters->getSearchInput();


			$builder
//				->add('datatable_bs3_js')
				->add("porto_admin_datatable_script", "internaljs", array(
					"template"   => 'porto_admin_datatable_script_template',
					"parameters" => $options,
					"dependencies" => array("datatable_bs3_js")
				));
			;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);

			$options['columns'] = $block->getColumns();
			$options['display_length'] = $block->getIDisplayLength();
			$options['state_save'] = $block->isStateSave();
			$options['processing'] = $block->isProcessing();
			$options['server_side'] = $block->isServerSide();
			$options['ajax'] = $block->getAjax();
			$options['query'] = $block->getQuery();
			$options['search_input'] = $block->getSearchInput();

		}

		public function getRenderTemplate() {
			return 'block_datatable_template';
		}

	}