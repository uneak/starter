<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\PortoAdminBundle\Blocks\Block;

class FormInterface extends Block
{

    protected $templateAlias = "layout_template_form_interface";
    protected $title = "Hello";
    protected $icon = "users";


    public function __construct() {
        parent::__construct();
        $this->setBrand("block_brand");
        $this->setContent(new PageBody());
    }


    public function getBrand()
    {
        return $this->getBlock("brand:layout");
    }

    public function setBrand($brand)
    {
        $this->removeBlock("brand:layout");
        $this->addBlock(array($brand, "block_template_brand_form_ui"), "brand:layout");
    }

    public function getContent()
    {
        return $this->getBlock("content:layout");
    }


    public function setContent($content)
    {
        $this->removeBlock("content:layout");
        $this->addBlock($content, "content:layout");
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon) {
        $this->icon = $icon;
    }


}
