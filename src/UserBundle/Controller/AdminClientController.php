<?php

	namespace UserBundle\Controller;

	use UserBundle\Entity\User;
	use UserBundle\Form\UserNewType;
	use UserBundle\Form\UserType;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\BlocksManagerBundle\Blocks\Block;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoutePool;
	use Uneak\FlatSkinBundle\Block\Component\DataTable;
	use Uneak\FlatSkinBundle\Block\DataTable\DataTableFilters;
	use Uneak\FlatSkinBundle\Block\Form\Form;
	use Uneak\FlatSkinBundle\Block\Menu\Menu;
	use Uneak\FlatSkinBundle\Block\Panel\Wrapper;
	use Doctrine\ORM\Query\Expr;

	class AdminClientController extends Controller {


		public function indexAction(FlattenRoute $route) {
			$blockManager = $this->get("uneak.blocksmanager");
			return $this->render('UserBundle:Admin:index.html.twig');

		}


	}
