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

        /**
         * @param mixed $blockBuilder
         */
        public function setBlockBuilder($blockBuilder) {
            $this->blockBuilder = $blockBuilder;
        }

        /**
         * @param mixed $layout
         */
        public function setLayout($layout) {
            $this->layout = $layout;
        }

        /**
         * @param mixed $layoutHeader
         */
        public function setLayoutHeader($layoutHeader) {
            $this->layoutHeader = $layoutHeader;
        }

        /**
         * @param mixed $layoutContent
         */
        public function setLayoutContent($layoutContent) {
            $this->layoutContent = $layoutContent;
        }

        /**
         * @param mixed $layoutContentBody
         */
        public function setLayoutContentBody($layoutContentBody) {
            $this->layoutContentBody = $layoutContentBody;
        }

        /**
         * @param mixed $layoutContentHeader
         */
        public function setLayoutContentHeader($layoutContentHeader) {
            $this->layoutContentHeader = $layoutContentHeader;
        }

        /**
         * @param mixed $layoutLeftSidebar
         */
        public function setLayoutLeftSidebar($layoutLeftSidebar) {
            $this->layoutLeftSidebar = $layoutLeftSidebar;
        }

        /**
         * @param mixed $layoutRightSidebar
         */
        public function setLayoutRightSidebar($layoutRightSidebar) {
            $this->layoutRightSidebar = $layoutRightSidebar;
        }

        /**
         * @param mixed $breadcrumb
         */
        public function setBreadcrumb($breadcrumb) {
            $this->breadcrumb = $breadcrumb;
        }



	}
