<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Content extends Block {

        protected $templateAlias = "layout_template_content";

		public function __construct() {
            parent::__construct();
            $this->setHeader("block_page_header");
            $this->setBody("block_page_body");
		}


        public function getHeader()
        {
            return $this->getBlock("header:layout");
        }

        public function setHeader($header)
        {
            $this->removeBlock("header:layout");
            $this->addBlock($header, "header:layout");
            return $this;
        }


        public function getBody()
        {
            return $this->getBlock("body:layout");
        }


        public function setBody($body)
        {
            $this->removeBlock("body:layout");
            $this->addBlock($body, "body:layout");
        }



	}
