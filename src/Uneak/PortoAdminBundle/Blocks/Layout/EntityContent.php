<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class EntityContent extends BlockModel {

        protected $templateAlias = "layout_template_entity_content";
        protected $uniqid;

		public function __construct() {
            $this->uniqid = uniqid('comp_');

            $header = new EntityHeader();
            $this->addBlock($header, "header");

            $body = new PageBody();
            $this->addBlock($body, "body");
		}

        public function getUniqid() {
            return $this->uniqid;
        }

        public function getHeader()
        {
            return $this->getBlock("header");
        }


        public function getBody()
        {
            return $this->getBlock("body");
        }




	}
