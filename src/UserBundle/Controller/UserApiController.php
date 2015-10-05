<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class UserApiController extends FOSRestController {

	/**
	 *
	 * @QueryParam(name="page", requirements="\d+", default="1", description="Pagination : Page a afficher.")
	 * @QueryParam(name="maxperpage", requirements="\d+", default="0", description="Pagination : Nombre d'entité par page a afficher.")
	 * 
	 * 
	 * @ApiDoc(
	 *  resource=true,
	 *  description="affiche la liste complete des utilisateurs"
	 * )
	 */
	// [GET] /user
	public function getUserAction(ParamFetcher $paramFetcher) {

		$data = array();
		$page = $paramFetcher->get('page');
		$maxperpage = $paramFetcher->get('maxperpage');

		$em = $this->getDoctrine()->getManager();
		$campaignsRepository = $em->getRepository('UserBundle:User');

		$campaigns = $campaignsRepository->findAll();

		$data = $campaigns;

		$view = new View();
		$view->setData($data);
		$view->setStatusCode(200);

		return $this->handleView($view);
	}

	
}
