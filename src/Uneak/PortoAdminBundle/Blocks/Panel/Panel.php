<?php

	namespace Uneak\PortoAdminBundle\Blocks\Panel;


    use Uneak\PortoAdminBundle\Blocks\Block;

    class Panel extends Block {

        protected $templateAlias = "block_template_panel";
		protected $title;
		protected $subtitle;
		protected $footer;
		protected $toggle = true;
		protected $dismiss = true;
		protected $collapsed = false;
		protected $badge;
		protected $badgeContext = "primary";
		protected $context;
		protected $featuredContext = null;
		protected $transparent = false;
		protected $headerTransparent = false;

		protected $actions = array();

		public function __construct() {
            parent::__construct();
		}

		public function addAction($icon, $title, $link) {
			$this->actions[] = array(
				'icon' => $icon,
				'title' => $title,
				'link' => $link,
			);
			return $this;
		}

		/**
		 * @return array
		 */
		public function getActions() {
			return $this->actions;
		}

		/**
		 * @param array $actions
		 */
		public function setActions($actions) {
			$this->actions = $actions;
		}


		/**
		 * @return string
		 */
		public function getTemplateAlias() {
			return $this->templateAlias;
		}

		/**
		 * @param string $templateAlias
		 */
		public function setTemplateAlias($templateAlias) {
			$this->templateAlias = $templateAlias;
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
		 * @return mixed
		 */
		public function getFooter() {
			return $this->footer;
		}

		/**
		 * @param mixed $footer
		 */
		public function setFooter($footer) {
			$this->footer = $footer;
		}

		/**
		 * @return boolean
		 */
		public function isToggle() {
			return $this->toggle;
		}

		/**
		 * @param boolean $toggle
		 */
		public function setToggle($toggle) {
			$this->toggle = $toggle;
		}

		/**
		 * @return boolean
		 */
		public function isDismiss() {
			return $this->dismiss;
		}

		/**
		 * @param boolean $dismiss
		 */
		public function setDismiss($dismiss) {
			$this->dismiss = $dismiss;
		}

		/**
		 * @return boolean
		 */
		public function isCollapsed() {
			return $this->collapsed;
		}

		/**
		 * @param boolean $collapsed
		 */
		public function setCollapsed($collapsed) {
			$this->collapsed = $collapsed;
		}

		/**
		 * @return mixed
		 */
		public function getBadge() {
			return $this->badge;
		}

		/**
		 * @param mixed $badge
		 */
		public function setBadge($badge) {
			$this->badge = $badge;
		}

		/**
		 * @return mixed
		 */
		public function getBadgeContext() {
			return $this->badgeContext;
		}

		/**
		 * @param mixed $badgeContext
		 */
		public function setBadgeContext($badgeContext) {
			$this->badgeContext = $badgeContext;
		}

		/**
		 * @return mixed
		 */
		public function getContext() {
			return $this->context;
		}

		/**
		 * @param mixed $context
		 */
		public function setContext($context) {
			$this->context = $context;
		}

		/**
		 * @return mixed
		 */
		public function getFeaturedContext() {
			return $this->featuredContext;
		}

		/**
		 * @param mixed $featuredContext
		 */
		public function setFeaturedContext($featuredContext) {
			$this->featuredContext = $featuredContext;
		}



		/**
		 * @return boolean
		 */
		public function isHeaderTransparent() {
			return $this->headerTransparent;
		}

		/**
		 * @param boolean $headerTransparent
		 */
		public function setHeaderTransparent($headerTransparent) {
			$this->headerTransparent = $headerTransparent;
		}

		/**
		 * @return boolean
		 */
		public function isTransparent() {
			return $this->transparent;
		}

		/**
		 * @param boolean $transparent
		 */
		public function setTransparent($transparent) {
			$this->transparent = $transparent;
		}






	}
