<?php

	namespace Uneak\PortoAdminBundle\Templates\Menu;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class MainMenuTemplate extends MenuTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			parent::buildAsset($builder, $parameters);
			$builder
                ->add('porto_admin_theme_navigation_js')

//				->add('card_block_script', 'internaljs', array(
//					'template'   => 'block_card_script',
//					'parameters' => array('item' => $parameters)
//				))
            ;
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {

			$root = $block->getRoot();
			$parameters = $block->getParameters();
			$renderer = $block->getRenderer();


			$root->setChildrenAttribute('class', 'nav nav-main');

			$options['root'] = $root;
			$options['parameters'] = array_merge($parameters, array(
				'template' => $templatesManager->getTemplate('knp_main_menu_template'),
				'leaf_class' => 'nav nav-children',
				'branch_class' => 'nav-parent',
				'ancestorClass' => 'nav-active nav-expanded',
				'currentClass' => 'nav-active',
			));
			$options['renderer'] = $renderer;
		}

        public function getRenderTemplate() {
            return 'block_main_menu_template';
        }

	}