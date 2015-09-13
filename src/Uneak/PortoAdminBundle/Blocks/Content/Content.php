<?php

	namespace Uneak\PortoAdminBundle\Blocks\Content;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Content extends Block {

        protected $templateAlias = "block_template_content";
        protected $content;

		public function __construct($content) {
            parent::__construct();
            $this->content = $content;
		}

        /**
         * @return mixed
         */
        public function getContent()
        {
            return $this->content;
        }

        /**
         * @param mixed $content
         */
        public function setContent($content)
        {
            $this->content = $content;
        }

	}
