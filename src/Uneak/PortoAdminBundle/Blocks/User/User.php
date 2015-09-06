<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\PortoAdminBundle\Blocks\Menu\UserMenu;

	class User extends BlockModel {
        protected $templateAlias = "block_template_user";

		protected $user;

		public function __construct($user = null) {
			$this->user = $user;
            $this->addBlock('block_user_menu', "menu");
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
