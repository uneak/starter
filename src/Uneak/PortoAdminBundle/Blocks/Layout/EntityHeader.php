<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\PortoAdminBundle\Blocks\Menu\EntityContentHeaderMenu;

    class EntityHeader extends BlockModel {

        protected $templateAlias = "layout_template_entity_header";
        protected $title;
        protected $rightBlocks;


		public function __construct() {
            $actionsMenu = new EntityContentHeaderMenu();
            $this->addBlock($actionsMenu, "actions_menu");
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
        public function getActions()
        {
            return $this->getBlock("actions_menu");
        }



        /**
         * @return mixed
         */
        public function getRightBlocks()
        {
            return $this->rightBlocks;
        }

        /**
         * @param mixed $rightBlocks
         */
        public function setRightBlocks($rightBlocks)
        {
            $this->rightBlocks = $rightBlocks;
        }


	}
