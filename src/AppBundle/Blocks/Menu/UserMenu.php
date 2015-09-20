<?php

	namespace AppBundle\Blocks\Menu;

	use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu as PortoAdminMenu;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRouteManager;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class UserMenu extends PortoAdminMenu {

        protected $menuHelper;
        protected $fRouteManager;
        protected $tokenStorage;


        public function __construct(MenuHelper $menuHelper, FlattenRouteManager $fRouteManager, TokenStorage $tokenStorage) {
            parent::__construct();
            $this->menuHelper = $menuHelper;
            $this->fRouteManager = $fRouteManager;
            $this->tokenStorage = $tokenStorage;


        }

        public function getRoot() {


            $user = $this->tokenStorage->getToken()->getUser();


            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');
            $separator = $factory->createItem('top-separator', array(
                'attributes' => array('class' => 'divider'),
            ));
            $root->addChild($separator);


            $flattenCrud = $this->fRouteManager->getFlattenRoute('user/subject');
            $items = $this->menuHelper->getItemList($flattenCrud->getMetaData('_menu'), $flattenCrud, array('user' => $user->getId()));
            foreach ($items as $item) {
                $root->addChild($item);
            }


            return $root;




            if (null !== $itemNews = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('user/index'))) {
                $itemNews->setExtra("badge", "19");
                $itemNews->setExtra("badge_context", "danger");
                $itemNews->setLinkAttribute("role", "menuitem");
                $itemNews->setLinkAttribute("tabindex", "-1");
                $root->addChild($itemNews);
            }

            $choices = $factory->createItem('bottom-separator', array(
                'attributes' => array('class' => 'divider'),
            ));
            $root->addChild($choices);

            if (null !== $itemNews2 = $this->menuHelper->createItem($this->fRouteManager->getFlattenRoute('admin'))) {
                $itemNews2->setExtra("badge", "15");
                $itemNews2->setLinkAttribute("role", "menuitem");
                $itemNews2->setLinkAttribute("tabindex", "-1");
                $root->addChild($itemNews2);
            }



            return $root;
        }

	}
