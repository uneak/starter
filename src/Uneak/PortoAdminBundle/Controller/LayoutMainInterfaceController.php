<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;


    class LayoutMainInterfaceController extends Controller implements LayoutControllerInterface {

        protected $blockBuilder;
        protected $layout;
        protected $layoutHeader;
        protected $layoutContent;
        protected $layoutContentBody;
        protected $layoutContentHeader;
        protected $layoutLeftSidebar;
        protected $layoutRightSidebar;
        protected $breadcrumb;


        public function setContainer(ContainerInterface $container = null) {
            parent::setContainer($container);
            $this->blockBuilder = $this->get("uneak.blocksmanager.builder");
            $this->blockBuilder->addBlock("layout", "block_main_interface");
            $this->layout = $this->blockBuilder->getBlock("layout");

            $this->layoutHeader = $this->layout->getHeader();
            $this->layoutContent = $this->layout->getContent();
            $this->layoutContentBody = $this->layoutContent->getBody();
            $this->layoutContentHeader = $this->layoutContent->getHeader();
            $this->breadcrumb = $this->layoutContentHeader->getBreadcrumb();

            $this->layoutLeftSidebar = $this->layout->getLeftSidebar();
            $this->layoutRightSidebar = $this->layout->getRightSidebar();

//            $this->layout->setLayoutStyle(MainInterface::LAYOUT_STYLE_DEFAULT);
//            $this->layout->setBackgroundColor(MainInterface::COLOR_DARK);
//            $this->layout->setHeaderColor(MainInterface::COLOR_DARK);
//            $this->layout->setSidebarLeftSize(MainInterface::SIDEBAR_LEFT_SIZE_MD);
        }



	}
