<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class User extends Block {
        protected $templateAlias = "block_template_user";

		protected $user;


		public function __construct($user = null) {
            parent::__construct();
			$this->user = $user;
			$this->setMenu('block_user_menu');
		}


		public function setMenu($menu)
		{
			$this->removeBlock("menu:layout");
			$this->addBlock(array($menu, 'block_template_user_menu'), "menu:layout");
			return $this;
		}


		public function getMenu() {
			return $this->getBlock("menu:layout");
		}

		public function getUser() {
			return $this->user;
		}

		public function setUser($user) {
			$this->user = $user;
		}




	}
