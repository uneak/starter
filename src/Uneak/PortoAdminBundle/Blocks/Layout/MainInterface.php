<?php

namespace Uneak\PortoAdminBundle\Blocks\Layout;

use Uneak\PortoAdminBundle\Blocks\Block;
use Uneak\PortoAdminBundle\Blocks\PNotify\PNotify;

class MainInterface extends Block
{

    const LAYOUT_STYLE_DEFAULT = "fixed";
    const LAYOUT_STYLE_BOXED = "boxed";
    const LAYOUT_STYLE_SCROLL = "scroll";

    const COLOR_LIGHT = "light";
    const COLOR_DARK = "dark";

    const SIDEBAR_LEFT_SIZE_XS = "xs";
    const SIDEBAR_LEFT_SIZE_SM = "sm";
    const SIDEBAR_LEFT_SIZE_MD = "md";


    protected $templateAlias = "layout_template_main_interface";
    protected $title = "Administration Interface";
    protected $leftSidebarCollapsed = false;
    protected $layoutStyle = self::LAYOUT_STYLE_DEFAULT;
    protected $backgroundColor = self::COLOR_LIGHT;
    protected $headerColor = self::COLOR_LIGHT;
    protected $sidebarLeftSize = self::SIDEBAR_LEFT_SIZE_MD;

    public function __construct() {
        parent::__construct();
        $this->setLeftSidebar("block_left_sidebar");
        $this->setRightSidebar("block_right_sidebar");
        $this->setHeader("block_header");
        $this->setContent("block_content");

        $this->addBlock(new PNotify(), "pnotify:pnotify");
    }

    /**
     * @return string
     */
    public function getLayoutStyle()
    {
        return $this->layoutStyle;
    }

    /**
     * @param string $layoutStyle
     */
    public function setLayoutStyle($layoutStyle)
    {
        $this->layoutStyle = $layoutStyle;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return string
     */
    public function getHeaderColor()
    {
        return $this->headerColor;
    }

    /**
     * @param string $headerColor
     */
    public function setHeaderColor($headerColor)
    {
        $this->headerColor = $headerColor;
    }

    /**
     * @return string
     */
    public function getSidebarLeftSize()
    {
        return $this->sidebarLeftSize;
    }

    /**
     * @param string $sidebarLeftSize
     */
    public function setSidebarLeftSize($sidebarLeftSize)
    {
        $this->sidebarLeftSize = $sidebarLeftSize;
    }

    /**
     * @return boolean
     */
    public function isLeftSidebarCollapsed()
    {
        return $this->leftSidebarCollapsed;
    }

    /**
     * @param boolean $leftSidebarCollapsed
     */
    public function setLeftSidebarCollapsed($leftSidebarCollapsed)
    {
        $this->leftSidebarCollapsed = $leftSidebarCollapsed;
    }


    public function getLeftSidebar() {
        return $this->getBlock("left_sidebar:layout");
    }


    public function setLeftSidebar($leftSidebar)
    {
        $this->leftSidebar = $leftSidebar;
        $this->removeBlock("left_sidebar:layout");
        $this->addBlock($leftSidebar, "left_sidebar:layout");
    }


    public function getRightSidebar()
    {
        return $this->getBlock("right_sidebar:layout");
    }


    public function setRightSidebar($rightSidebar)
    {
        $this->removeBlock("right_sidebar:layout");
        $this->addBlock($rightSidebar, "right_sidebar:layout");
    }


    public function getHeader()
    {
        return $this->getBlock("header:layout");
    }


    public function setHeader($header)
    {
        $this->removeBlock("header:layout");
        $this->addBlock($header, "header:layout");
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


}
