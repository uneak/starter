<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MemberBundle\Templating\Helper;

use MemberBundle\Security\OAuthUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Templating\Helper\Helper;

/**
 * OAuthHelper
 *
 * @author Alexander <iam.asm89@gmail.com>
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class OAuthHelper extends Helper
{
    /**
     * @var RequestStack
     */
    private $requestStack;


    /**
     * @var OAuthUtils
     */
    private $oauthUtils;

    /**
     * @param OAuthUtils $oauthUtils
     */
    public function __construct(OAuthUtils $oauthUtils, RequestStack $requestStack)
    {
        $this->oauthUtils = $oauthUtils;
        $this->requestStack = $requestStack;
    }

//    /**
//     * @param null|Request $request
//     */
//    public function setRequest(Request $request = null)
//    {
//        $this->request = $request;
//    }

    /**
     * @return array
     */
    public function getResourceOwners()
    {
        return $this->oauthUtils->getResourceOwners();
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getLoginUrl($name)
    {

        $this->container->get("request");
        return $this->oauthUtils->getLoginUrl($this->requestStack->getCurrentRequest(), $name);
    }

    /**
     * @param string $name
     * @param string $redirectUrl     Optional
     * @param array  $extraParameters Optional
     *
     * @return string
     */
    public function getAuthorizationUrl($name, $redirectUrl = null, array $extraParameters = array())
    {
        return $this->oauthUtils->getAuthorizationUrl($this->requestStack->getCurrentRequest(), $name, $redirectUrl, $extraParameters);
    }

    /**
     * Returns the name of the helper.
     *
     * @return string The helper name
     */
    public function getName()
    {
        return 'member_oauth';
    }
}
