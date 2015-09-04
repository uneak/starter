<?php

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Breadcrumb\Breadcrumb;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
	use Uneak\PortoAdminBundle\Blocks\User\User;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Doctrine\ORM\Query\Expr;

	class AdminController extends Controller {


		public function indexAction(FlattenRoute $route, Request $request) {

			$blockManager = $this->get("uneak.blocksmanager");
			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
			$fRouteManager = $this->get("uneak.routesmanager.flattenmanager");

			$factory = $menuHelper->getFactory();
			$root = $factory->createItem('root');
			$root->setChildrenAttribute('class', 'nav nav-main');

			$choices = $factory->createItem('test', array(
				'label' => 'choix',
				'icon' => 'user'
			));
			$root->addChild($choices);

			$choices2 = $factory->createItem('test2', array(
				'label' => 'choiXx',
				'icon' => 'user'
			));
			$root->addChild($choices2);

			if (null !== $itemNews = $menuHelper->createItem($fRouteManager->getFlattenRoute('user/index'))) {
				$itemNews->setExtra("badge", "15");
				$itemNews->setExtra("badge_context", "danger");
				$choices->addChild($itemNews);
			}

			if (null !== $itemNews2 = $menuHelper->createItem($fRouteManager->getFlattenRoute('admin'))) {
				$itemNews2->setExtra("badge", "15");
				$choices->addChild($itemNews2);
			}

			$options = array(
				'template' => 'UneakPortoAdminBundle:Menu:main_menu_template.html.twig',
				'leaf_class' => 'nav nav-children',
				'branch_class' => 'nav-parent',
				'ancestorClass' => 'nav-active nav-expanded',
				'currentClass' => 'nav-active',
			);

			$menu = new Menu($root, $options);
			$blockManager->addBlock($menu, 'main-menu');



			$tokenStorage = $this->get("security.token_storage");
			$user = $tokenStorage->getToken()->getUser();



			$root = $factory->createItem('root');
			$choices = $factory->createItem('top-separator', array(
				'attributes' => array('class' => 'divider'),
			));
			$root->addChild($choices);

			if (null !== $itemNews = $menuHelper->createItem($fRouteManager->getFlattenRoute('user/index'))) {
				$itemNews->setExtra("badge", "19");
				$itemNews->setExtra("badge_context", "danger");
				$itemNews->setLinkAttribute("role", "menuitem");
				$itemNews->setLinkAttribute("tabindex", "-1");
				$root->addChild($itemNews);
			}

			if (null !== $itemNews2 = $menuHelper->createItem($fRouteManager->getFlattenRoute('admin'))) {
				$itemNews2->setExtra("badge", "15");
				$itemNews2->setLinkAttribute("role", "menuitem");
				$itemNews2->setLinkAttribute("tabindex", "-1");
				$root->addChild($itemNews2);
			}

			$user = new User($user, $root);
			$blockManager->addBlock($user, 'user');


			$breadcrumb = new Breadcrumb();
			$blockManager->addBlock($breadcrumb, 'breadcrumb');



			return $this->render('UneakPortoAdminBundle:Layout:interface.html.twig');



		}


	}
