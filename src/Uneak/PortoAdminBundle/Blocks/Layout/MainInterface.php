<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\BlocksManagerBundle\Blocks\BlockModel;

class MainInterface extends BlockModel
{

    protected $templateAlias = "layout_template_main_interface";
    protected $title = "Administration Interface";

    public function __construct() {
        $this->setLeftSidebar("block_left_sidebar");
        $this->setRightSidebar("block_right_sidebar");
        $this->setHeader("block_header");
        $this->setContent("block_content");
    }


    public function getLeftSidebar() {
        return $this->getBlock("left_sidebar");
    }


    public function setLeftSidebar($leftSidebar)
    {
        $this->leftSidebar = $leftSidebar;
        $this->removeBlock("left_sidebar");
        $this->addBlock($leftSidebar, "left_sidebar");
    }


    public function getRightSidebar()
    {
        return $this->getBlock("right_sidebar");
    }


    public function setRightSidebar($rightSidebar)
    {
        $this->removeBlock("right_sidebar");
        $this->addBlock($rightSidebar, "right_sidebar");
    }


    public function getHeader()
    {
        return $this->getBlock("header");
    }


    public function setHeader($header)
    {
        $this->removeBlock("header");
        $this->addBlock($header, "header");
    }


    public function getContent()
    {
        return $this->getBlock("content");
    }


    public function setContent($content)
    {
        $this->removeBlock("content");
        $this->addBlock($content, "content");
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


}
