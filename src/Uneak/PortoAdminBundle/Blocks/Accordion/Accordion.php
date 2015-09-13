<?php

	namespace Uneak\PortoAdminBundle\Blocks\Accordion;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;
    use Uneak\PortoAdminBundle\Blocks\Block;

    class Accordion extends Block {

        protected $templateAlias = "block_template_accordion";

        protected $toggle = false;
        protected $collapseOther = false;
        protected $tabs = array();

		public function __construct() {
            parent::__construct();
		}

        /**
         * @return boolean
         */
        public function isCollapseOther()
        {
            return $this->collapseOther;
        }

        /**
         * @param boolean $collapseOther
         */
        public function setCollapseOther($collapseOther)
        {
            $this->collapseOther = $collapseOther;
        }

        /**
         * @return boolean
         */
        public function isToggle()
        {
            return $this->toggle;
        }

        /**
         * @param boolean $toggle
         */
        public function setToggle($toggle)
        {
            $this->toggle = $toggle;
        }


        public function addTab($icon, $title, $context, BlockModelInterface $block)
        {
            $id = count($this->tabs);
            $this->tabs[$id] = array(
                'icon' => $icon,
                'context' => $context,
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


	}
