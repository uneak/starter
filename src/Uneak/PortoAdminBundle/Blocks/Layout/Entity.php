<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\PortoAdminBundle\Blocks\Block;
use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

class Entity extends Block
{

    protected $templateAlias = "layout_template_entity";

    public function __construct() {
        parent::__construct();

        $toolbarMenu = new Menu();
        $this->addBlock(array($toolbarMenu, 'block_template_entity_toolbar_menu'), "toolbar_menu");

        $entitySideBar = new EntitySidebar();
        $this->addBlock($entitySideBar, "entity_sidebar");

//        $content = new EntityContentScroll();
        $content = new EntityContent();
        $this->addBlock($content, "content");

    }

    public function getToolbar()
    {
        return $this->getBlock("toolbar_menu");
    }

    public function getEntitySidebar()
    {
        return $this->getBlock("entity_sidebar");
    }


    public function getContent()
    {
        return $this->getBlock("content");
    }



}
