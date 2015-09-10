<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\BlocksManagerBundle\Blocks\BlockModel;

class Entity extends BlockModel
{

    protected $templateAlias = "layout_template_entity";

    public function __construct() {
        $entitySideBar = new EntitySidebar();
        $this->addBlock($entitySideBar, "entity_sidebar");

        $content = new EntityContent();
        $this->addBlock($content, "content");

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
