<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class PageHeader extends Block {

        protected $templateAlias = "layout_template_page_header";
        protected $title;

		public function __construct($title = "") {
            parent::__construct();
            $this->setBreadcrumb(array("block_breadcrumb", "block_template_breadcrumb"));
            $this->title = $title;
		}


        public function getBreadcrumb()
        {
            return $this->getBlock("breadcrumb");
        }

        public function setBreadcrumb($breadcrumb)
        {
            $this->removeBlock("breadcrumb");
            $this->addBlock($breadcrumb, "breadcrumb");
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
