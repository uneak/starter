<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
	use Uneak\PortoAdminBundle\Blocks\Menu\UserMenu;

	class User extends BlockModel {

		protected $user;
		protected $menu;

		public function __construct($user, ItemInterface $menuItem = null) {
			$this->user = $user;
            $this->menu = new UserMenu($menuItem);
            $this->addBlock($this->menu, "menu", 0, "user");
		}

		public function getMenu() {
			return $this->getBlock("menu", "user");
		}

		public function setMenuItem(ItemInterface $menuItem) {
            $this->menu->setRoot($menuItem);
		}

        public function getMenuItem() {
            return $this->menu->getRoot();
        }

		public function getUser() {
			return $this->user;
		}

		public function setUser($user) {
			$this->user = $user;
		}


		public function getTemplateName() {
			return "block_user";
		}

	}
