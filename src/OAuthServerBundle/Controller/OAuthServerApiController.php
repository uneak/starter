<?php

namespace OAuthServerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use OAuthServerBundle\Form\OAuthServerType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Uneak\PortoAdminBundle\Exception\APIException;


class OAuthServerApiController extends FOSRestController
{

    /**
     * affiche la liste complete des clients oauth
     *
     *
     * @QueryParam(name="offset", requirements="\d+", default=null, description="Pagination : offset.")
     * @QueryParam(name="limit", requirements="\d+", default=null, description="Pagination : how many objects to return.")
     * @QueryParam(name="fields", default=null, description="comma separated list of fields to include, ex: fields=id,subject,customer_name,updated_at")
     * @QueryParam(array=true, name="like", default=null, description="Like = ex: like[label]=%marc%")
     * @QueryParam(array=true, name="eq", default=null, description="Equal == ex: eq[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(array=true, name="ne", default=null, description="Not Equal != ex: ne[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(array=true, name="lt", default=null, description="Less than < ex: lt[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(array=true, name="gt", default=null, description="Greater than > ex: gt[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(array=true, name="le", default=null, description="Less than or equal <= ex: le[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(array=true, name="ge", default=null, description="Greater than or equal >= ex: ge[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(name="sort", default=null, description="comma separated list of fields to sort, ex: -lastName,+model")
     *
     * @ApiDoc(
     *      resource=true,
     *      section="Client OAuth",
     *      description="affiche la liste complete des clients Oauth",
     *      deprecated=false,
     *      tags={
     *          "beta" = "#9999FF",
     *          "danger" = "#ff0000"
     *      },
     *      views = { "default" },
     *      output="OAuthServer\Entity\Client",
     *
     *      statusCodes={
     *          200="OK – Eyerything is working.",
     *          403="Forbidden – The server understood the request, but is refusing it or the access is not allowed.",
     *          404="Not found – There is no resource behind the URI."
     *      }
     * )
     */
    // [GET] /oauths
    public function getOauthsAction(ParamFetcher $paramFetcher)
    {

        $filters = array(
            'offset' => $paramFetcher->get('offset'),
            'limit' => $paramFetcher->get('limit'),
            'fields' => $paramFetcher->get('fields'),
            'sort' => $paramFetcher->get('sort'),
            'like' => $paramFetcher->get('like'),
            'eq' => $paramFetcher->get('eq'),
            'ne' => $paramFetcher->get('ne'),
            'lt' => $paramFetcher->get('lt'),
            'gt' => $paramFetcher->get('gt'),
            'le' => $paramFetcher->get('le'),
            'ge' => $paramFetcher->get('ge'),
        );



        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');
        $data = $handler->all($filters);
        $count = $handler->count($filters);


        $paginations = array();

        $offset = ($filters['offset']) ? $filters['offset'] : 0;
        $limit = ($filters['limit']) ? $filters['limit'] : null;

        $firstFilters = $filters;
        $firstFilters['offset'] = 0;
        if ($firstFilters['offset'] != $offset) {
            $paginations['first'] = $this->generateUrl('api_v1_oauth_server_get_oauths', $firstFilters, UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $prevFilters = $filters;
        if ($offset > 0) {
            $prevFilters['offset'] = $offset - 1;
            $paginations['prev'] = $this->generateUrl('api_v1_oauth_server_get_oauths', $prevFilters, UrlGeneratorInterface::ABSOLUTE_URL);
        }


        if ($limit) {
            if (($offset+1) * $limit < $count) {
                $nextFilters = $filters;
                $nextFilters['offset'] = $offset + 1;
                $paginations['next'] = $this->generateUrl('api_v1_oauth_server_get_oauths', $nextFilters, UrlGeneratorInterface::ABSOLUTE_URL);
            };

            $lastFilters = $filters;
            $lastFilters['offset'] = floor($count/$limit) - 1;
            $lastFilters['offset'] = ($lastFilters['offset'] < 0) ? 0 : $lastFilters['offset'];
            if ($lastFilters['offset'] != $offset) {
                $paginations['last'] = $this->generateUrl('api_v1_oauth_server_get_oauths', $lastFilters, UrlGeneratorInterface::ABSOLUTE_URL);
            }

        }

        $linkHeaders = array();
        foreach ($paginations as $rel => $url) {
            $linkHeaders[] = "<".$url.">; rel=\"".$rel."\"";
        }


        $view = $this->view($data, Response::HTTP_OK);
        if (count($linkHeaders)) {
            $view->setHeader("Link", join(",", $linkHeaders));
        }
        $view->setHeader("X-Total-Count", $count);
        return $this->handleView($view);
    }


    /**
     * Get single Client OAuth,
     *
     * @ApiDoc(
     *      resource=true,
     *      section="Client OAuth",
     *      description="Get single Client OAuth by Id",
     *      deprecated=false,
     *      output = "OAuthServerBundle\Entity\Client",
     *      statusCodes = {
     *          200 = "OK – Eyerything is working",
     *          404 = "Not found – There is no resource behind the URI"
     *      }
     * )
     *
     *
     * @param int $id id
     *
     * @return array
     *
     */
    public function getOauthAction($id)
    {
        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');

        try {
            $data = $handler->get($id);
            $view = $this->view($data, Response::HTTP_OK);

        } catch (APIException $exception) {
            $view = $this->view($exception->getData(), $exception->getCode());
        }

        return $this->handleView($view);


    }


    /**
     * Create a OAuth Server from the submitted data.
     *
     * @ApiDoc(
     *      resource = true,
     *      section="Client OAuth",
     *      description = "Creates a new OAuth Server from the submitted data.",
     *      input = "OAuthServerBundle\Form\OAuthServerType",
     *      statusCodes = {
     *          201 = "OK – New resource has been created",
     *          400 = "Bad Request – The request was invalid or cannot be served. The exact error should be explained in the error payload. E.g. The JSON is not valid",
     *          403 = "Forbidden – The server understood the request, but is refusing it or the access is not allowed."
     *      }
     *)
     *
     *
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface | View
     */
    public function postOauthAction(Request $request)
    {
        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');

        $formType = new OAuthServerType();
//        $parameters = $request->request->get($formType->getName());
        $parameters = $request->request->all();
//        var_dump($parameters);
//        die();
        try {
            $data = $handler->post($formType, $parameters);
            $routeOptions = array(
                'id' => $data->getId(),
                '_format' => $request->get('_format')
            );

            $view = $this->routeRedirectView('api_v1_oauth_server_get_oauth', $routeOptions, Response::HTTP_CREATED);

        } catch (APIException $exception) {
            $view = $this->view($exception->getData(), $exception->getCode());
        }

        return $this->handleView($view);

    }



    /**
     * Edit a OAuth Server or create if not exist.
     *
     * @ApiDoc(
     *      resource = true,
     *      section="Client OAuth",
     *      description = "Edit a OAuth Server or create if not exist.",
     *      input = "OAuthServerBundle\Form\OAuthServerType",
     *      statusCodes = {
     *          201 = "OK – New resource has been created",
     *          400 = "Bad Request – The request was invalid or cannot be served. The exact error should be explained in the error payload. E.g. The JSON is not valid",
     *          403 = "Forbidden – The server understood the request, but is refusing it or the access is not allowed."
     *      }
     *)
     *
     *
     *
     * @param Request $request the request object
     * @param int     $id      id
     *
     * @return FormTypeInterface | View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function putOauthAction(Request $request, $id)
    {
        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');

        $formType = new OAuthServerType();
//        $parameters = $request->request->get($formType->getName());
        $parameters = $request->request->all();
//        var_dump($parameters);
//        die();

        try {
            if (!($data = $handler->get($id))) {
                $statusCode = Response::HTTP_CREATED;
                $data = $handler->post($formType, $parameters);
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $data = $handler->put($formType, $data, $parameters);
            }

            $routeOptions = array(
                'id' => $data->getId(),
                '_format' => $request->get('_format')
            );

            $view = $this->routeRedirectView('api_v1_oauth_server_get_oauth', $routeOptions, $statusCode);

        } catch (APIException $exception) {
            $view = $this->view($exception->getData(), $exception->getCode());
        }

        return $this->handleView($view);
    }


    /**
     * Update a OAuth Server.
     *
     * @ApiDoc(
     *      resource = true,
     *      section="Client OAuth",
     *      description = "Update a OAuth Server.",
     *      input = "OAuthServerBundle\Form\OAuthServerType",
     *      statusCodes = {
     *          201 = "Returned when is created",
     *          204 = "Returned when successful",
     *          400 = "Returned when the form has errors"
     *      }
     *)
     *
     *
     *
     * @param Request $request the request object
     * @param int     $id      id
     *
     * @return FormTypeInterface | View
     *
     * @throws NotFoundHttpException when not exist
     */
    public function patchOauthAction(Request $request, $id)
    {
        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');

        $formType = new OAuthServerType();
//        $parameters = $request->request->get($formType->getName());
        $parameters = $request->request->all();
//        var_dump($parameters);
//        die();

        try {
            if (!($data = $handler->get($id))) {
                $statusCode = Response::HTTP_NOT_FOUND;
                $data = array();
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $data = $handler->patch($formType, $data, $parameters);
            }

            $routeOptions = array(
                'id' => $data->getId(),
                '_format' => $request->get('_format')
            );

            $view = $this->routeRedirectView('api_v1_oauth_server_get_oauth', $routeOptions, $statusCode);

        } catch (APIException $exception) {
            $view = $this->view($exception->getData(), $exception->getCode());
        }

        return $this->handleView($view);
    }

    /**
     * Delete a OAuth Server.
     *
     * @ApiDoc(
     *      resource = true,
     *      section="Client OAuth",
     *      description = "Delete a OAuth Server.",
     *      statusCodes = {
     *          204 = "OK – The resource was successfully deleted",
     *          404 = "Not found – There is no resource behind the URI."
     *      }
     * )
     *
     *
     * @param int $id id
     *
     * @return boolean
     *
     * @throws NotFoundHttpException when not exist
     */
    public function deleteOauthAction($id)
    {
        $handler = $this->container->get('uneak.admin.oauth.server.api.handler');
        try {
            $handler->delete($id);
            $view = $this->view(null, Response::HTTP_NO_CONTENT);

        } catch (APIException $exception) {
            $view = $this->view($exception->getData(), $exception->getCode());
        }

        return $this->handleView($view);

    }


    /**
     * Presents the form to use to create a new.
     *
     * @ApiDoc(
     *      resource = true,
     *      section="Client OAuth",
     *      statusCodes = {
     *          200 = "OK – Eyerything is working",
     *      }
     * )
     *
     *
     * @return FormTypeInterface
     */
    public function newOauthAction()
    {
        $view = $this->view($this->createForm(new OAuthServerType()), Response::HTTP_OK);
        return $this->handleView($view);
    }

}
