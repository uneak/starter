<?php

	namespace Uneak\PortoAdminBundle\Blocks\Counter;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Counter extends Block {

        const FEATURED_NONE = "";
        const FEATURED_TOP = "top";
        const FEATURED_BOTTOM = "bottom";
        const FEATURED_LEFT = "left";
        const FEATURED_RIGHT = "right";

        const SIZE_XLG = "xlg";
        const SIZE_MD = "md";
        const SIZE_SM = "sm";
        const SIZE_XS = "xs";



        protected $templateAlias = "block_template_counter";
		protected $title;
		protected $icon;
		protected $value;
		protected $comment;
		protected $context;
		protected $featured = null;
		protected $size = null;


		public function __construct() {
            parent::__construct();
		}

        /**
         * @return null
         */
        public function getSize()
        {
            return $this->size;
        }

        /**
         * @param null $size
         */
        public function setSize($size)
        {
            $this->size = $size;
        }

        /**
         * @return null
         */
        public function getFeatured()
        {
            return $this->featured;
        }

        /**
         * @param null $featured
         */
        public function setFeatured($featured)
        {
            $this->featured = $featured;
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
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @param mixed $value
         */
        public function setValue($value)
        {
            $this->value = $value;
        }

        /**
         * @return mixed
         */
        public function getComment()
        {
            return $this->comment;
        }

        /**
         * @param mixed $comment
         */
        public function setComment($comment)
        {
            $this->comment = $comment;
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
