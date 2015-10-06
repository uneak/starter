<?php

	namespace UserBundle\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\DependencyInjection\ContainerInterface;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Doctrine\ORM\Query\Expr;
	use UserBundle\Form\UserAccountType;

	class UserAdminController extends Controller {


		public function indexAction(FlattenRoute $route) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);
			$layout->buildGridPage($route);

			return $blockBuilder->render("layout");
		}

		public function showAction(FlattenRoute $route) {

			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);

			return $blockBuilder->render("layout");


		}

		public function editAction(FlattenRoute $route, Request $request) {
			$crudHandler = $this->get("uneak.admin.user.crud.handler");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);

			$form = $crudHandler->getRouteForm($route, 'POST');
			$form->add('submit', 'submit', array('label' => 'Modifier'));

			$layout->buildFormPage($form, $route->getMetaData('_label'));


			$entityRoute = $route;
			while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
				$entityRoute = $entityRoute->getParent();
			}


			if ($request->getMethod() == 'POST') {
				$form->handleRequest($request);
				if ($form->isValid()) {

					$crudHandler->persistEntity($form);

					return $this->redirect($entityRoute->getChild('show')->getRoutePath());
				} else {
					$this->addFlash('error', 'Votre formulaire est invalide.');
				}
			}


			return $blockBuilder->render("layout");
		}

		public function newAction(FlattenRoute $route, Request $request) {
			$crudHandler = $this->get("uneak.admin.user.crud.handler");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);

			$form = $crudHandler->getRouteForm($route, 'POST');
			$form->add('submit', 'submit', array('label' => 'Créer'));

			$layout->buildFormPage($form, $route->getMetaData('_label'));


			if ($request->getMethod() == 'POST') {
				$form->handleRequest($request);
				if ($form->isValid()) {

					$crudHandler->persistEntity($form);

					return $this->redirect($route->getChild('*/index')->getRoutePath());
				} else {
					$this->addFlash('error', 'Votre formulaire est invalide.');
				}
			}


			return $blockBuilder->render("layout");
		}


		public function accountAction(FlattenRoute $route, Request $request) {
			$crudHandler = $this->get("uneak.admin.user.crud.handler");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);


			$entityRoute = $route;
			while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
				$entityRoute = $entityRoute->getParent();
			}
			$entity = ($entityRoute) ? $entityRoute->getParameterSubject() : null;

			$formType = new UserAccountType();

			$form = $crudHandler->getForm($formType, $entity, 'POST');
			$form->get('role')->setData($entity->getRoles()[0]);
			$form->add('submit', 'submit', array('label' => 'Modifier'));

			$infoPanel = new Panel();
			$infoPanel->setTitle("informations");
			$infoPanel->isCollapsed(false);
			$infoPanel->isDismiss(false);
			$infoPanel->isToggle(false);
			$layout->getSubLayoutContentBody()->addBlock($infoPanel, 'info');

			$layout->buildFormPage($form, $route->getMetaData('_label'));



			if ($request->getMethod() == 'POST') {

				$form->handleRequest($request);
				if ($form->isValid()) {

					$crudHandler->persistAccountEntity($form);

					return $this->redirect($entityRoute->getChild('show')->getRoutePath());
				} else {
					$this->addFlash('error', 'Votre formulaire est invalide.');
				}
			}


			return $blockBuilder->render("layout");


		}

		public function indexGridAction(FlattenRoute $route, Request $request) {
			$crudHandler = $this->get("uneak.admin.user.crud.handler");
			return $crudHandler->getDatatableJSon($route, $request);
		}




	}
