<?php

	namespace Uneak\PortoAdminBundle\Templates\Menu;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityContentHeaderMenuTemplate extends MenuTemplate {

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

			$root->setChildrenAttribute('class', 'list-unstyled m-none pt-lg pb-lg');



			$options['root'] = $root;
			$options['parameters'] = array_merge($parameters, array(
				'template' => $templatesManager->getTemplate('knp_entity_content_header_menu_template'),
			));
			$options['renderer'] = $renderer;
		}

        public function getRenderTemplate() {
            return 'block_entity_content_header_menu_template';
        }

	}