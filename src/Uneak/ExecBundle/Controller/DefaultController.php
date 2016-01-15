<?php

namespace Uneak\ExecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UneakExecBundle:Default:index.html.twig', array('name' => $name));
    }
}
