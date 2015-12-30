<?php

	namespace Uneak\RoutesManagerBundle\Helper;

	use Doctrine\ORM\Query\Expr;
	use Knp\Menu\FactoryInterface;
	use Symfony\Component\HttpFoundation\RequestStack;
	use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Uneak\RoutesManagerBundle\Security\Authorization\Voter\RouteVoter;

	class MenuHelper {

		private $factory;
		private $authorization;

		public function __construct(FactoryInterface $factory, AuthorizationChecker $authorization) {
			$this->factory = $factory;
			$this->authorization = $authorization;
		}

		public function getFactory() {
			return $this->factory;
		}

		public function createItem(FlattenRoute $flattenRoute, $parameters = array()) {


			if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $flattenRoute) === true) {

				$label = $flattenRoute->getMetaData("_label");
				$icon = $flattenRoute->getMetaData("_icon");
				$badge = $flattenRoute->getMetaData("_badge");
				$badgeContext = $flattenRoute->getMetaData("_badge_context");
				$uri = ($flattenRoute->isEnabled()) ? $flattenRoute->getRoutePath() : "#";


				$menu = array();
				if ($label) {
					$menu['label'] = $label;
				}
				if ($icon) {
					$menu['icon'] = $icon;
				}
				if ($badge) {
					$menu['badge'] = $badge;
				}
				if ($badgeContext) {
					$menu['badge_context'] = $badgeContext;
				}


				$menu['uri'] = $uri;

				$menu = array_merge_recursive($parameters, $menu);

				return $this->factory->createItem($flattenRoute->getId(), $menu);
			}

			return null;

		}

		public function getItemList($actions, FlattenRoute $flattenRoute, $parameters = null) {
			$itemList = array();
			foreach ($actions as $action) {
				$menuItem = $this->createItem($flattenRoute->getChild($action, $parameters));
				if ($menuItem) {
					array_push($itemList, $menuItem);
				}
			}
			return $itemList;
		}


		public function createMenu($actions, FlattenRoute $flattenRoute, $parameters = null) {
			$itemList = $this->getItemList($actions, $flattenRoute, $parameters);
			$root = $this->factory->createItem('root');
			foreach ($itemList as $item) {
				$root->addChild($item);
			}
			return $root;
		}



	}
