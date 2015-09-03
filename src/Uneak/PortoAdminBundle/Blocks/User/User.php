<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\BlocksManagerBundle\Blocks\BlockModelInterface;

	class User extends BlockModel {

		protected $user;

		public function __construct($user, BlockModelInterface $menu = null) {
			$this->user = $user;
			if ($menu) {
				$this->setMenu($menu);
			}
		}

		public function getMenu() {
			return $this->getBlock("menu", "user");
		}

		public function setMenu($menu) {
			$this->addBlock($menu, "menu", $priority = 0, $group = "user");
		}

		public function getUser() {
			return $this->user;
		}

		public function setUser($user) {
			$this->user = $user;
		}


		public function getBlockName() {
			return "block_user";
		}

	}
