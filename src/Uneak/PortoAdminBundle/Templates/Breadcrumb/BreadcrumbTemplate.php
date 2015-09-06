<?php

	namespace Uneak\PortoAdminBundle\Templates\Breadcrumb;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockTemplate;
	use Uneak\PortoAdminBundle\Templates\Menu\MenuTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class BreadcrumbTemplate extends MenuTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			parent::buildAsset($builder, $parameters);
//			$builder
//				->add('material_design_lite_js')
//                ->add('material_design_lite_css')
//				->add('card_block_script', 'internaljs', array(
//					'template'   => 'block_card_script',
//					'parameters' => array('item' => $parameters)
//				));
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {

			$root = $block->getRoot();
			$parameters = $block->getParameters();
			$renderer = $block->getRenderer();

//			$root->setChildrenAttribute('class', 'breadcrumbs');

			$options['root'] = $root;
			$options['parameters'] = array_merge($parameters, array(
				'template' => $templatesManager->getTemplate('knp_breadcrumb_menu_template'),
				'leaf_class' => 'nav nav-children',
				'branch_class' => 'nav-parent',
				'ancestorClass' => 'nav-active nav-expanded',
				'currentClass' => 'nav-active',
				'depth' => 1,
			));
			$options['renderer'] = $renderer;




		}

//		public function getRenderTemplate() {
//			return 'block_breadcrumb_template';
//		}

	}