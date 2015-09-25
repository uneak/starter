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
use Uneak\PortoAdminBundle\Controller\LayoutMainInterfaceController;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class LayoutProfileController extends LayoutMainInterfaceController
{

    protected $entity;
    protected $entityLayout;
    protected $entityLayoutContent;
    protected $entityLayoutContentBody;
    protected $entityLayoutSidebar;
    protected $entityLayoutToolbar;
    protected $entityLayoutContentActions;


    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->layout->setLeftSidebarCollapsed(true);

        $this->layoutHeader = $this->layout->getHeader();
        $this->layoutContent = $this->layout->getContent();
        $this->layoutContentBody = $this->layoutContent->getBody();
        $this->layoutContentHeader = $this->layoutContent->getHeader();
        $this->layoutLeftSidebar = $this->layout->getLeftSidebar();
        $this->layoutRightSidebar = $this->layout->getRightSidebar();

        $this->entityLayout = new Entity();
        $this->entityLayoutContent = $this->entityLayout->getContent();
        $this->entityLayoutContentBody = $this->entityLayoutContent->getBody();
        $this->entityLayoutContentActions = $this->entityLayoutContent->getActions();
        $this->entityLayoutSidebar = $this->entityLayout->getEntitySidebar();
        $this->entityLayoutToolbar = $this->entityLayout->getToolbar();

        $this->layoutContentBody->addBlock($this->entityLayout);


//        $twig = new \Twig_Environment(new \Twig_Loader_Array(array()));

        $blockManager = $this->get("uneak.blocksmanager.blocks");
        $menu = new Menu($blockManager->getBlock("block_user_menu")->getRoot());
        $this->entityLayoutSidebar->addWidget("menu", $menu, false, 999999);


        $this->layoutContentHeader->setTitle("Profile");


        $this->entityLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);

        $this->entity = $this->getUser();
        if (!is_object($this->entity) || !$this->entity instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $this->entityLayoutContent->setTitle("Profile");
        $this->entityLayoutContent->setSubtitle($this->entity->getFirstName()." ".$this->entity->getLastName());


        $vichHelper = $this->get("vich_uploader.templating.helper.uploader_helper");
        $photoFile = $vichHelper->asset($this->entity, "imageFile");

        if ($photoFile) {
            $photo = new Photo();
            $photo->setPhoto($photoFile);
            $this->entityLayoutSidebar->addWidget("photo", $photo, false, 9999999);
        }


    }
}
