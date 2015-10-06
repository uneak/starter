<?php

    namespace Uneak\PortoAdminBundle\LayoutBuilder;


    class AdminFormLayoutBuilder implements LayoutBuilderInterface {

        protected $layout;
        protected $layoutContent;


        public function setLayout($layout) {
            $this->layout = $layout;
            $this->layoutContent = $this->layout->getContent();
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
        public function getLayoutContent() {
            return $this->layoutContent;
        }



	}
