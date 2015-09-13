<?php

	namespace Uneak\PortoAdminBundle\Templates\Panel;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class PanelTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
			$builder
				->add('porto_admin_theme_panels_js')
			;

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['subtitle'] = $block->getSubtitle();
			$options['footer'] = $block->getFooter();
			$options['toggle'] = $block->isToggle();
			$options['dismiss'] = $block->isDismiss();
			$options['collapsed'] = $block->isCollapsed();
			$options['badge'] = $block->getBadge();
			$options['badge_context'] = $block->getBadgeContext();
			$options['context'] = $block->getContext();
			$options['featured_context'] = $block->getFeaturedContext();
			$options['header_transparent'] = $block->isHeaderTransparent();
			$options['transparent'] = $block->isTransparent();

			$options['actions'] = $block->getActions();

			$options['blocks'] = $block->getBlocks();

		}

		public function getRenderTemplate() {
			return 'block_panel_template';
		}

	}