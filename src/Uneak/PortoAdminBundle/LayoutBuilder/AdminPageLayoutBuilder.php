<?php

    namespace Uneak\PortoAdminBundle\LayoutBuilder;



    use Symfony\Component\Form\FormView;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;

    class AdminPageLayoutBuilder implements LayoutBuilderInterface {


        protected $layout;
        protected $layoutHeader;
        protected $layoutContent;
        protected $layoutContentBody;
        protected $layoutContentHeader;
        protected $layoutLeftSidebar;
        protected $layoutRightSidebar;
        protected $breadcrumb;



        public function setLayout($layout) {

            $this->layout = $layout;
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


        public function buildFormPage(FormView $formView, $title) {

            $formBlock = new Form($formView);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle($title);
            $panel->setCollapsed(false);
            $panel->setDismiss(false);
            $panel->setToggle(false);
            $panel->addBlock($formBlock);
            $this->layoutContentBody->addBlock($panel, 'form');

            return $formView;
        }



        /**
         * @return mixed
         */
        public function getLayout() {
            return $this->layout;
        }

        /**
         * @return mixed
         */
        public function getLayoutHeader() {
            return $this->layoutHeader;
        }

        /**
         * @return mixed
         */
        public function getLayoutContent() {
            return $this->layoutContent;
        }

        /**
         * @return mixed
         */
        public function getLayoutContentBody() {
            return $this->layoutContentBody;
        }

        /**
         * @return mixed
         */
        public function getLayoutContentHeader() {
            return $this->layoutContentHeader;
        }

        /**
         * @return mixed
         */
        public function getLayoutLeftSidebar() {
            return $this->layoutLeftSidebar;
        }

        /**
         * @return mixed
         */
        public function getLayoutRightSidebar() {
            return $this->layoutRightSidebar;
        }

        /**
         * @return mixed
         */
        public function getBreadcrumb() {
            return $this->breadcrumb;
        }




    }
