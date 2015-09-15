<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class EntityContentScroll extends Block {

        protected $templateAlias = "layout_template_entity_content_scroll";
        protected $title;
        protected $subtitle;

		public function __construct() {
            parent::__construct();
            $this->setBody(new PageBody());
		}

        public function setBody($body)
        {
            $this->removeBlock("body");
            $this->addBlock($body, "body");
        }


        public function getBody()
        {
            return $this->getBlock("body");
        }

        /**
         * @return mixed
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getSubtitle()
        {
            return $this->subtitle;
        }

        /**
         * @param mixed $subtitle
         */
        public function setSubtitle($subtitle)
        {
            $this->subtitle = $subtitle;
        }




	}
