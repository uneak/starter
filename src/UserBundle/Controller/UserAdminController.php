<?php

	namespace UserBundle\Controller;

	use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use UserBundle\Entity\User;

    class UserAdminController extends LayoutEntityController {


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


			$form = $crudHandler->getForm($route, Request::METHOD_POST);
			$form->get('role')->setData($entity->getRoles()[0]);
			$form->add('submit', 'submit', array('label' => 'Modifier'));

			$infoPanel = new Panel();
			$infoPanel->setTitle("informations");
			$infoPanel->isCollapsed(false);
			$infoPanel->isDismiss(false);
			$infoPanel->isToggle(false);
			$layout->getSubLayoutContentBody()->addBlock($infoPanel, 'info');

			$layout->buildFormPage($form, $route->getMetaData('_label'));


			if ($request->getMethod() == Request::METHOD_POST) {

				$form->handleRequest($request);
				if ($form->isValid()) {


                    $entity = $form->getData();
                    $entity->setEnabled($entity->getStateProfile() == User::STATE_PROFILE_ACCEPT);
                    $entity->setRoles(array($form->get('role')->getData()));

					$crudHandler->persistEntity($form);

					return $this->redirect($entityRoute->getChild('show')->getRoutePath());
				} else {
					$this->addFlash('error', 'Votre formulaire est invalide.');
				}
			}


			return $blockBuilder->render("layout");


		}


	}
