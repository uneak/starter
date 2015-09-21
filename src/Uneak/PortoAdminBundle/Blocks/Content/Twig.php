<?php

	namespace Uneak\PortoAdminBundle\Blocks\Content;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Twig extends Block {

        protected $templateAlias = "block_template_twig";
        protected $template;
        protected $parameters = array();

		public function __construct($template, $parameters = array()) {
            parent::__construct();
            $this->template = $template;
            $this->parameters = $parameters;
		}

        /**
         * @return mixed
         */
        public function getTemplate()
        {
            return $this->template;
        }

        /**
         * @param mixed $template
         */
        public function setTemplate($template)
        {
            $this->template = $template;
        }

        /**
         * @return array
         */
        public function getParameters() {
            return $this->parameters;
        }

        /**
         * @param array $parameters
         */
        public function setParameters($parameters) {
            $this->parameters = $parameters;
        }



	}
