<?php

    namespace Uneak\PortoAdminBundle\LayoutBuilder;

    use Symfony\Component\Form\FormFactoryInterface;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class AdminPageProfileLayoutBuilder extends AdminPageSubLayoutBuilder {

        /**
         * @var \Uneak\RoutesManagerBundle\Helper\MenuHelper
         */
        private $menuHelper;
        /**
         * @var \Symfony\Component\Form\FormFactoryInterface
         */
        private $formFactory;
        /**
         * @var \Vich\UploaderBundle\Templating\Helper\UploaderHelper
         */
        private $uploaderHelper;
        /**
         * @var \Uneak\BlocksManagerBundle\Blocks\BlocksManager
         */
        private $blocksManager;

        public function __construct(BlocksManager $blocksManager, MenuHelper $menuHelper, FormFactoryInterface $formFactory, UploaderHelper $uploaderHelper) {
            $this->menuHelper = $menuHelper;
            $this->formFactory = $formFactory;
            $this->uploaderHelper = $uploaderHelper;
            $this->blocksManager = $blocksManager;
        }



        public function buildProfileLayout(UserInterface $user) {

            $menu = new Menu($this->blocksManager->getBlock("block_user_menu")->getRoot());
            $this->subLayoutSidebar->addWidget("menu", $menu, false, 999999);

            $this->layoutContentHeader->setTitle("Profile");

            $this->subLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);

            //            $entity = $this->controller->getUser();
            //            if (!is_object($entity) || !$entity instanceof UserInterface) {
            //                throw new AccessDeniedException('This user does not have access to this section.');
            //            }

            $this->subLayoutContent->setTitle("Profile");
            $this->subLayoutContent->setSubtitle($user->getFirstName()." ".$user->getLastName());

            $photoFile = $this->uploaderHelper->asset($user, "imageFile");

            if ($photoFile) {
                $photo = new Photo();
                $photo->setPhoto($photoFile);
                $this->subLayoutSidebar->addWidget("photo", $photo, false, 9999999);
            }
        }




        public function buildIndex(FlattenRoute $route) {

        }



    }
