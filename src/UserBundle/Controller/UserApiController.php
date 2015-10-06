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
		 * @QueryParam(name="maxperpage", requirements="\d+", default="0", description="Pagination : Nombre d'entité
		 *                                par page a afficher.")
		 *
		 *
		 * @ApiDoc(
		 *  resource=true,
		 * 	section="Utilisateurs",
		 *  description="affiche la liste complete des utilisateurs",
		 * 	deprecated=false,
		 * 	tags={
		 *  	"stable",
		 *  	"deprecated" = "#ff0000"
		 * 	},
		 * 	views = { "default" },
		 * 	input="Your\Namespace\Form\Type\YourType",
		 *  output="Your\Namespace\Class",
		 * 	requirements={
		 * 		{
		 * 			"name"="limit",
		 * 			"dataType"="integer",
		 * 			"requirement"="\d+",
		 * 			"description"="how many objects to return"
		 * 		}
		 * 	},
		 * 	parameters={
		 * 		{"name"="categoryId", "dataType"="integer", "required"=true, "description"="category id"}
		 * 	},
		 * 	filters={
		 * 		{"name"="a-filter", "dataType"="integer"},
		 * 		{"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
		 *  },
		 *  statusCodes={
		 *  	200="Returned when successful",
		 * 		403="Returned when the user is not authorized to say hello",
		 *  	404={
		 *           "Returned when the user is not found",
		 *           "Returned when something else is not found"
		 * 		}
		 *  }
		 * )
		 */
		// [GET] /users
		public function getUsersAction(ParamFetcher $paramFetcher) {

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
