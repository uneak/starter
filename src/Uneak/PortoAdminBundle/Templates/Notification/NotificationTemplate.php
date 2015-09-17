<?php

	namespace Uneak\PortoAdminBundle\Templates\Notification;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class NotificationTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {
//			$builder
//				->add('material_design_lite_js')
//                ->add('material_design_lite_css')
//				->add('card_block_script', 'internaljs', array(
//					'template'   => 'block_card_script',
//					'parameters' => array('item' => $parameters)
//				));
		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['title'] = $block->getTitle();
			$options['icon'] = $block->getIcon();
			$options['badge'] = $block->getBadge();

			$options['items'] = $block->getBlock(":notification_item");

		}

		public function getRenderTemplate() {
			return 'block_notification_template';
		}

	}