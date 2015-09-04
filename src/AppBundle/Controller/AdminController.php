<?php

	namespace AppBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Brand\Brand;
	use Uneak\PortoAdminBundle\Blocks\Breadcrumb\Breadcrumb;
	use Uneak\PortoAdminBundle\Blocks\Menu\MainMenu;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
	use Uneak\PortoAdminBundle\Blocks\Message\IconMessage;
	use Uneak\PortoAdminBundle\Blocks\Message\Message;
	use Uneak\PortoAdminBundle\Blocks\Notification\Notification;
	use Uneak\PortoAdminBundle\Blocks\Notification\Notifications;
	use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
	use Uneak\PortoAdminBundle\Blocks\Search\Search;
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

			$menu = new MainMenu($root);
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



			$root = $factory->createItem('root');
			$choices = $factory->createItem('test', array(
				'label' => 'choix',
				'icon' => 'user',
				'badge' => "15",
				'uri' => '#',
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


			$breadcrumb = new Breadcrumb($root);
			$blockManager->addBlock($breadcrumb, 'breadcrumb');


			$notificationTask = new Notification("Taches", "user", "13");
			$notificationTask->add(new ProgressBar("title", "25%", 25));
			$notificationTask->add(new ProgressBar("title", "35%", 35));
			$notificationTask->add(new ProgressBar("title", "10 ventes", 68));
			$notificationTask->add(new Message("title", "10 ventes"));
			$notificationTask->add(new Message("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes "));
			$notificationTask->add(new IconMessage("Marc Galoyer", "10 ventes 10 ventes 10 ventes 10 ventes 10 ventes ", "user"));


			$notifications = new Notifications();
			$notifications->add($notificationTask);
			$notifications->add($notificationTask);
			$notifications->add($notificationTask);
			$blockManager->addBlock($notifications, 'notifications');


			$search = new Search("http://uneak.fr");
			$blockManager->addBlock($search, 'search');

			$brand = new Brand("uneak", "http://uneak.fr", "bundles/uneakportoadmin/images/volkswagen_logo.jpg");
			$blockManager->addBlock($brand, 'brand');

			return $this->render('UneakPortoAdminBundle:Layout:interface.html.twig');



		}


	}
