<?php

	namespace Uneak\PortoAdminBundle\Blocks\Teaser;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;

	class Teaser extends BlockModel {

        protected $templateAlias = "block_template_teaser";
		protected $title;
		protected $icon;
		protected $description;
		protected $context;
		protected $headerContext;
		protected $horizontal = false;


		public function __construct() {
		}

        /**
         * @return boolean
         */
        public function isHorizontal()
        {
            return $this->horizontal;
        }

        /**
         * @param boolean $horizontal
         */
        public function setHorizontal($horizontal)
        {
            $this->horizontal = $horizontal;
        }


        /**
         * @return mixed
         */
        public function getHeaderContext()
        {
            return $this->headerContext;
        }

        /**
         * @param mixed $headerContext
         */
        public function setHeaderContext($headerContext)
        {
            $this->headerContext = $headerContext;
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
        public function getIcon()
        {
            return $this->icon;
        }

        /**
         * @param mixed $icon
         */
        public function setIcon($icon)
        {
            $this->icon = $icon;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return mixed
         */
        public function getContext()
        {
            return $this->context;
        }

        /**
         * @param mixed $context
         */
        public function setContext($context)
        {
            $this->context = $context;
        }





	}
