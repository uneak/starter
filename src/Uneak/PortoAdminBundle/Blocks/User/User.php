<?php

	namespace Uneak\PortoAdminBundle\Blocks\User;

	use Knp\Menu\ItemInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockModel;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;

    class User extends BlockModel {

		protected $user;
		protected $menu;

		public function __construct($user, ItemInterface $menuItem = null) {
			$this->user = $user;
            $this->menu = new Menu(null, array(
                'template' => 'UneakPortoAdminBundle:Menu:user_menu_template.html.twig',
                'currentClass' => 'active',
            ));
            if ($menuItem) {
                $this->setMenuItem($menuItem);
            }
            $this->addBlock($this->menu, "menu", $priority = 0, $group = "user");
		}

		public function getMenu() {
			return $this->getBlock("menu", "user");
		}

		public function setMenuItem(ItemInterface $menuItem) {
            $this->menu->setRoot($menuItem);
            $menuItem->setChildrenAttribute('class', 'list-unstyled');
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


		public function getBlockName() {
			return "block_user";
		}

	}
