<?php

namespace Uneak\TemplatesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UneakTemplatesManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
