<?php

	namespace Uneak\PortoAdminBundle\Blocks\Todo;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class Todo extends Block {
        protected $templateAlias = "block_template_todo";


		protected $slug;
		protected $content;


		public function __construct($slug, $content) {
            parent::__construct();
			$this->content = $content;
			$this->slug = $slug;
		}

		/**
		 * @return mixed
		 */
		public function getSlug() {
			return $this->slug;
		}

		/**
		 * @param mixed $slug
		 */
		public function setSlug($slug) {
			$this->slug = $slug;
		}

		/**
		 * @return mixed
		 */
		public function getContent() {
			return $this->content;
		}

		/**
		 * @param mixed $content
		 */
		public function setContent($content) {
			$this->content = $content;
		}



		public function setMenu($menu)
		{
			$this->removeBlock("menu:todo");
			$this->addBlock($menu, "menu:todo");
			return $this;
		}


		public function getMenu() {
			return $this->getBlock("menu:todo");
		}



	}
