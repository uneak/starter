<?php

namespace ProspectBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Uneak\PortoAdminBundle\Exception\InvalidFormException;


class ProspectApiController extends FOSRestController
{

    /**
     * affiche la liste complete des prospects
     *
     *
     * @QueryParam(name="offset", requirements="\d+", default=null, description="Pagination : offset.")
     * @QueryParam(name="limit", requirements="\d+", default=null, description="Pagination : how many objects to return.")
     * @QueryParam(name="fields", default=null, description="comma separated list of fields to include, ex: fields=id,subject,customer_name,updated_at")
     * @QueryParam(map=true, name="like", default=null, description="Like = ex: like[label]=%marc%")
     * @QueryParam(map=true, name="eq", default=null, description="Equal == ex: eq[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(map=true, name="ne", default=null, description="Not Equal != ex: ne[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(map=true, name="lt", default=null, description="Less than < ex: lt[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(map=true, name="gt", default=null, description="Greater than > ex: gt[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(map=true, name="le", default=null, description="Less than or equal <= ex: le[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(map=true, name="ge", default=null, description="Greater than or equal >= ex: ge[createdAt]=2015-15-42 15:15:14")
     * @QueryParam(name="sort", default=null, description="comma separated list of fields to sort, ex: -lastName,+model")
     *
     * @ApiDoc(
     *      resource=true,
     *      section="Prospect",
     *      description="affiche la liste complete des prospects",
     *      deprecated=false,
     *      tags={
     *          "beta" = "#9999FF",
     *          "danger" = "#ff0000"
     *      },
     *      views = { "default" },
     *      output="Uneak\ProspectBundle\Entity\Prospect",
     *
     *      statusCodes={
     *          200="OK – Eyerything is working.",
     *          403="Forbidden – The server understood the request, but is refusing it or the access is not allowed.",
     *          404="Not found – There is no resource behind the URI."
     *      }
     * )
     */
    // [GET] /users
    public function getProspectsAction(ParamFetcher $paramFetcher)
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


        $handler = $this->container->get('uneak.admin.prospect.api.handler');
        $data = $handler->all($filters);
        $count = $handler->count($filters);


        $paginations = array();

        $offset = ($filters['offset']) ? $filters['offset'] : 0;
        $limit = ($filters['limit']) ? $filters['limit'] : null;

        $firstFilters = $filters;
        $firstFilters['offset'] = 0;
        if ($firstFilters['offset'] != $offset) {
            $paginations['first'] = $this->generateUrl('api_v1_prospect_get_prospects', $firstFilters, UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $prevFilters = $filters;
        if ($offset > 0) {
            $prevFilters['offset'] = $offset - 1;
            $paginations['prev'] = $this->generateUrl('api_v1_prospect_get_prospects', $prevFilters, UrlGeneratorInterface::ABSOLUTE_URL);
        }


        if ($limit) {
            if (($offset+1) * $limit < $count) {
                $nextFilters = $filters;
                $nextFilters['offset'] = $offset + 1;
                $paginations['next'] = $this->generateUrl('api_v1_prospect_get_prospects', $nextFilters, UrlGeneratorInterface::ABSOLUTE_URL);
            };

            $lastFilters = $filters;
            $lastFilters['offset'] = floor($count/$limit) - 1;
            $lastFilters['offset'] = ($lastFilters['offset'] < 0) ? 0 : $lastFilters['offset'];
            if ($lastFilters['offset'] != $offset) {
                $paginations['last'] = $this->generateUrl('api_v1_prospect_get_prospects', $lastFilters, UrlGeneratorInterface::ABSOLUTE_URL);
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




}
