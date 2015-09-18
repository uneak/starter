<?php

	namespace Uneak\PortoAdminBundle\Blocks\Layout;

	use Uneak\PortoAdminBundle\Blocks\Block;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

	class EntityContent extends Sidebar {

		const TEMPLATE_TYPE_FIXED = "layout_template_entity_content";
		const TEMPLATE_TYPE_SCROLL = "layout_template_entity_content_scroll";

		protected $templateAlias = self::TEMPLATE_TYPE_FIXED;
		protected $title;
		protected $subtitle;

		public function __construct() {
			parent::__construct();
			$this->setActions(new Menu());
			$this->setBody(new PageBody());
		}

		public function addWidget($id, $widget, $wrap = true, $priority = null) {
			$this->addBlock($widget, $id . ":widgets", $priority);

			return $this;
		}

		public function setBody($body) {
			$this->removeBlock("body:layout");
			$this->addBlock($body, "body:layout");
		}

		public function getBody() {
			return $this->getBlock("body:layout");
		}


		public function setActions($actions) {
			$this->removeBlock("actions_menu:layout");
			$this->addBlock(array($actions, 'block_template_entity_content_header_menu'), "actions_menu:layout");
		}

		public function getActions() {
			return $this->getBlock("actions_menu:layout");
		}

		/**
		 * @return mixed
		 */
		public function getTitle() {
			return $this->title;
		}

		/**
		 * @param mixed $title
		 */
		public function setTitle($title) {
			$this->title = $title;
		}

		/**
		 * @return mixed
		 */
		public function getSubtitle() {
			return $this->subtitle;
		}

		/**
		 * @param mixed $subtitle
		 */
		public function setSubtitle($subtitle) {
			$this->subtitle = $subtitle;
		}

		/**
		 * @param string $templateType
		 */
		public function setTemplateType($templateType) {
			$this->setTemplateAlias($templateType);
		}


	}
