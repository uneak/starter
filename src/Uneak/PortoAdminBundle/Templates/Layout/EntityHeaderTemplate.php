<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class EntityHeaderTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();

            $widgets = $block->getWidgets();
//            foreach ($widgets as $widget) {
//                $widget->addClass(CssClasses::m_none);
//            }
            $options['widgets'] = $widgets;

		}

		public function getRenderTemplate() {
			return 'layout_entity_header_template';
		}

	}