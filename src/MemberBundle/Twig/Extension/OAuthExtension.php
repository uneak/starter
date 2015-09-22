<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MemberBundle\Twig\Extension;

use MemberBundle\Templating\Helper\OAuthHelper;

/**
 * OAuthExtension
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class OAuthExtension extends \Twig_Extension
{
    /**
     * @var OAuthHelper
     */
    protected $helper;

    /**
     * @param OAuthHelper $helper
     */
    public function __construct(OAuthHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'member_oauth_authorization_url' => new \Twig_Function_Method($this, 'getAuthorizationUrl'),
            'member_oauth_login_url'         => new \Twig_Function_Method($this, 'getLoginUrl'),
            'member_oauth_resource_owners'   => new \Twig_Function_Method($this, 'getResourceOwners')
        );
    }

    /**
     * @return array
     */
    public function getResourceOwners()
    {
        return $this->helper->getResourceOwners();
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getLoginUrl($name)
    {
        return $this->helper->getLoginUrl($name);
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
        return $this->helper->getAuthorizationUrl($name, $redirectUrl, $extraParameters);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'member_oauth';
    }
}
