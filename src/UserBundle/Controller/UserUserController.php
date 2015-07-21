<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserUserController extends Controller
{
    public function registerAction()
    {
        return $this->get('pugx_multi_user.registration_manager')->register('UserBundle\\Entity\\UserUser');
    }
}
