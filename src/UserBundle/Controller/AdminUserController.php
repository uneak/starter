<?php

	namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    use Uneak\PortoAdminBundle\Blocks\Content\Content;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContentScroll;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\PortoAdminBundle\Blocks\UIElements\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Controller\LayoutController;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;
    use UserBundle\Entity\User;
    use UserBundle\Form\UserAccountType;
    use UserBundle\Form\UserType;

    class AdminUserController extends LayoutEntityController {




        public function accountAction(FlattenRoute $route, Request $request)
        {
            $form = $this->createForm(new UserAccountType(), $this->entity);
            $form->get('role')->setData($this->entity->getRoles()[0]);
            $form->add('submit', 'submit', array('label' => 'Modifier'));

            if ($request->getMethod() == 'POST') {

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $stateProfile = $form->get('stateProfile')->getData();
                    $this->entity->setEnabled($stateProfile == User::STATE_PROFILE_ACCEPT);
                    $this->entity->setRoles(array($form->get('role')->getData()));


                    $userManager = $this->get('uneak.user_manager');
                    $userManager->updateUser($this->entity);

                    return $this->redirect($this->entityRoute->getChild('show')->getRoutePath());
                } else {
                    $this->addFlash('error', 'Votre formulaire est invalide.');
                }
            }


            $infoPanel = new Panel();
            $infoPanel->setTitle("informations");
            $infoPanel->isCollapsed(false);
            $infoPanel->isDismiss(false);
            $infoPanel->isToggle(false);
//            $panel->addBlock();
            $this->entityLayoutContentBody->addBlock($infoPanel, 'info');


            $formBlock = new Form($form);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle($route->getMetaData('_label'));
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $this->entityLayoutContentBody->addBlock($panel, 'form');


        }


	}
