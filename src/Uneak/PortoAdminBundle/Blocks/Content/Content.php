<?php

	namespace Uneak\PortoAdminBundle\Blocks\Content;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

    class Content extends BlockModel {

        protected $templateAlias = "block_template_content";
        protected $content;

		public function __construct($content) {
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
