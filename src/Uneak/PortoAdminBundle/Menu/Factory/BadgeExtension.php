<?php

	namespace Uneak\PortoAdminBundle\Menu\Factory;

	use Knp\Menu\Factory\ExtensionInterface;
	use Knp\Menu\ItemInterface;


	class BadgeExtension implements ExtensionInterface {
		/**
		 * Builds the full option array used to configure the item.
		 *
		 * @param array $options
		 *
		 * @return array
		 */
		public function buildOptions(array $options) {
			return array_merge(
				array(
					'icon'          => null,
					'badge'         => null,
					'badge_context' => "primary",
				),
				$options
			);
		}

		/**
		 * Configures the newly created item with the passed options
		 *
		 * @param ItemInterface $item
		 * @param array         $options
		 */
		public function buildItem(ItemInterface $item, array $options) {
			$item->setExtra("icon", $options['icon']);
			$item->setExtra("badge", $options['badge']);
			$item->setExtra("badge_context", $options['badge_context']);
		}


	}

