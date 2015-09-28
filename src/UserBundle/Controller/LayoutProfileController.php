<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

    namespace UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Uneak\PortoAdminBundle\Blocks\Content\Twig;
use Uneak\PortoAdminBundle\Blocks\Form\Form;
use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\PortoAdminBundle\Controller\LayoutMainInterfaceController;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class LayoutProfileController extends LayoutEntityController
{

}
