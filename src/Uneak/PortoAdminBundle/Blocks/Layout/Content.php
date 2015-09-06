<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Content extends BlockModel {

        protected $templateAlias = "layout_template_content";

		public function __construct() {
            $this->setHeader("block_page_header");
            $this->setBody("block_page_body");
		}


        public function getHeader()
        {
            return $this->getBlock("header");
        }

        public function setHeader($header)
        {
            $this->removeBlock("header");
            $this->addBlock($header, "header");
            return $this;
        }


        public function getBody()
        {
            return $this->getBlock("body");
        }


        public function setBody($body)
        {
            $this->removeBlock("body");
            $this->addBlock($body, "body");
        }



	}
