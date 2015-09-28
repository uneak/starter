<?php

	namespace Uneak\PortoAdminBundle\Templates\Layout;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class HeaderTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['brand'] = $block->getBrand();
			$options['search'] = $block->getSearch();

//			ldd($block->getNotifications());

			$options['notifications'] = $block->getNotifications();
			$options['user'] = $block->getUser();
		}

		public function getRenderTemplate() {
			return 'layout_header_template';
		}

	}