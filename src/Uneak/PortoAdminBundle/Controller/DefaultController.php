<?php

namespace Uneak\PortoAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UneakPortoAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
