<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

    use Uneak\PortoAdminBundle\Blocks\Block;

    class User extends Block {
        protected $templateAlias = "block_template_user";

		protected $user;


		public function __construct($user = null) {
            parent::__construct();
			$this->user = $user;
            $this->addBlock(array('block_user_menu', 'block_template_user_menu'), "menu");
		}

		public function getMenu() {
			return $this->getBlock("menu");
		}

		public function getUser() {
			return $this->user;
		}

		public function setUser($user) {
			$this->user = $user;
		}




	}
