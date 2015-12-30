<?php

namespace ProspectGroupBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Uneak\PortoAdminBundle\Exception\InvalidFormException;


class ProspectGroupApiController extends FOSRestController
{

    /**
     * affiche la liste complete des utilisateurs
     *
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Pagination : Page a afficher.")
     * @QueryParam(name="maxperpage", requirements="\d+", default="0", description="Pagination : Nombre d'entité
     *                                par page a afficher.")
     *
     *
     * @ApiDoc(
     *  resource=true,
     *    section="Utilisateurs",
     *  description="affiche la liste complete des utilisateurs",
     *    deprecated=false,
     *    tags={
     *    "stable",
     *    "deprecated" = "#ff0000"
     *    },
     *    views = { "default" },
     *    input="Your\Namespace\Form\Type\YourType",
     *  output="Your\Namespace\Class",
     *    requirements={
     *        {
     *            "name"="limit",
     *            "dataType"="integer",
     *            "requirement"="\d+",
     *            "description"="how many objects to return"
     *        }
     *    },
     *    parameters={
     *        {"name"="categoryId", "dataType"="integer", "required"=true, "description"="category id"}
     *    },
     *    filters={
     *        {"name"="a-filter", "dataType"="integer"},
     *        {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  },
     *  statusCodes={
     *    200="Returned when successful",
     *        403="Returned when the user is not authorized to say hello",
     *    404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *        }
     *  }
     * )
     */
    // [GET] /users
    public function getProspectGroupsAction(ParamFetcher $paramFetcher)
    {

        $data = array();
        $page = $paramFetcher->get('page');
        $maxperpage = $paramFetcher->get('maxperpage');

        $em = $this->getDoctrine()->getManager();
        $groupsRepository = $em->getRepository('UneakFieldGroupBundle:FieldGroup');

        $groups = $groupsRepository->findAll();

        $data = $groups;

        $view = new View();
        $view->setData($data);
        $view->setStatusCode(200);

        return $this->handleView($view);
    }


    /**
     * Get single Page,
     *
     * @ApiDoc(
     *  resource=true,
     *    section="Utilisateurs",
     *  description="affiche l'utilisateur par sont identifiant",
     *    deprecated=false,
     *   output = "Uneak\FieldGroupBundle\Entity\FieldGroup",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getProspectGroupAction($id)
    {
        $handler = $this->container->get('uneak.admin.user.crud.handler');
        $user = $handler->get($id);

        if (!$user) {
            throw new NotFoundHttpException(sprintf('The user \'%s\' was not found.', $id));
        }


        $view = new View();
        $view->setData($user);
        $view->setStatusCode(200);

        return $this->handleView($view);
    }


    /**
     * Create a Page from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   section="Utilisateurs",
     *   description = "Creates a new page from the submitted data.",
     *   input = "Acme\BlogBundle\Form\PageType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *  }
     *)
     *
     *
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface | View
     */
    public function postProspectGroupAction(Request $request)
    {
        $handler = $this->container->get('uneak.admin.user.crud.handler');
        $entity = $handler->createEntity();
        $formType = new RegistrationFormType();
        $form = $handler->getForm($formType, $entity, Request::METHOD_POST);

        try {

            $user = $handler->post($form, $request->request->all());

            $routeOptions = array(
                'id' => $user->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_v1_user_get_user', $routeOptions, Response::HTTP_CREATED);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }


}
