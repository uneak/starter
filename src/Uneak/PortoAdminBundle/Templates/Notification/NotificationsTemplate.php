<?php

	namespace Uneak\PortoAdminBundle\Templates\Notification;

	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
	use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
	use Uneak\PortoAdminBundle\Templates\BlockTemplate;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

	class NotificationsTemplate extends BlockTemplate {

		public function buildAsset(AssetsBuilderManager $builder, $parameters) {

		}

		public function buildOptions(TemplatesManager $templatesManager, $block, array &$options) {
            parent::buildOptions($templatesManager, $block, $options);
			$options['notifications'] = $block->getNotifications();

		}

		public function getRenderTemplate() {
			return 'block_notifications_template';
		}

	}