<?php

	namespace Uneak\PortoAdminBundle\Blocks\Tabs;

    use Uneak\BlocksManagerBundle\Blocks\BlockInterface;
    use Uneak\PortoAdminBundle\Blocks\Block;

    class Tabs extends Block {

        protected $templateAlias = "block_template_tabs";

        protected $context;
        protected $justified = false;
        protected $bottom = false;
        protected $right = false;
        protected $vertical = false;

        protected $tabs = array();

		public function __construct() {
            parent::__construct();
		}

        public function addTab($icon, $title, BlockInterface $block)
        {
            $id = count($this->tabs);
            $this->tabs[$id] = array(
                'icon' => $icon,
                'title' => $title,
                'block' => $block,
            );
            $this->addBlock($block, $id);
        }

        /**
         * @return array
         */
        public function getTabs()
        {
            return $this->tabs;
        }

        /**
         * @return boolean
         */
        public function isVertical()
        {
            return $this->vertical;
        }

        /**
         * @param boolean $vertical
         */
        public function setVertical($vertical)
        {
            $this->vertical = $vertical;
        }

        /**
         * @return boolean
         */
        public function isBottom()
        {
            return $this->bottom;
        }

        /**
         * @param boolean $bottom
         */
        public function setBottom($bottom)
        {
            $this->bottom = $bottom;
        }

        /**
         * @return boolean
         */
        public function isRight()
        {
            return $this->right;
        }

        /**
         * @param boolean $right
         */
        public function setRight($right)
        {
            $this->right = $right;
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

        /**
         * @return boolean
         */
        public function isJustified()
        {
            return $this->justified;
        }

        /**
         * @param boolean $justified
         */
        public function setJustified($justified)
        {
            $this->justified = $justified;
        }


	}
