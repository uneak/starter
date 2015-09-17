<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\PortoAdminBundle\Blocks\Block;
use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

class Entity extends Block
{

    protected $templateAlias = "layout_template_entity";

    public function __construct() {
        parent::__construct();

        $this->setToolbar(new Menu());
        $this->setEntitySidebar(new EntitySidebar());
        $this->setContent(new EntityContent());

    }


    public function setToolbar($toolbar)
    {
        $this->removeBlock("toolbar_menu:layout");
        $this->addBlock(array($toolbar, 'block_template_entity_toolbar_menu'), "toolbar_menu:layout");
    }

    public function getToolbar()
    {
        return $this->getBlock("toolbar_menu:layout");
    }


    public function setEntitySidebar($entitySidebar)
    {
        $this->removeBlock("entity_sidebar:layout");
        $this->addBlock($entitySidebar, "entity_sidebar:layout");
    }

    public function getEntitySidebar()
    {
        return $this->getBlock("entity_sidebar:layout");
    }

    public function setContent($content)
    {
        $this->removeBlock("content:layout");
        $this->addBlock($content, "content:layout");
    }

    public function getContent() {
        return $this->getBlock("content:layout");
    }



}
