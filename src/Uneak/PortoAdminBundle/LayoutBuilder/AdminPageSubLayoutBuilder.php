<?php

    namespace Uneak\PortoAdminBundle\LayoutBuilder;

    use Symfony\Component\Form\FormFactoryInterface;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class AdminPageSubLayoutBuilder extends AdminPageLayoutBuilder{

        protected $subLayout;
        protected $subLayoutContent;
        protected $subLayoutContentBody;
        protected $subLayoutSidebar;
        protected $subLayoutToolbar;
        protected $subLayoutContentActions;


        public function setLayout($layout) {
            parent::setLayout($layout);

            $this->layout->setLeftSidebarCollapsed(true);

            $this->subLayout = new Entity();
            $this->subLayoutContent = $this->subLayout->getContent();
            $this->subLayoutContentBody = $this->subLayoutContent->getBody();
            $this->subLayoutContentActions = $this->subLayoutContent->getActions();
            $this->subLayoutSidebar = $this->subLayout->getEntitySidebar();
            $this->subLayoutToolbar = $this->subLayout->getToolbar();

            $this->layoutContentBody->addBlock($this->subLayout);

        }



        /**
         * @return mixed
         */
        public function getSubLayout() {
            return $this->subLayout;
        }

        /**
         * @return mixed
         */
        public function getSubLayoutContent() {
            return $this->subLayoutContent;
        }

        /**
         * @return mixed
         */
        public function getSubLayoutContentBody() {
            return $this->subLayoutContentBody;
        }

        /**
         * @return mixed
         */
        public function getSubLayoutSidebar() {
            return $this->subLayoutSidebar;
        }

        /**
         * @return mixed
         */
        public function getSubLayoutToolbar() {
            return $this->subLayoutToolbar;
        }

        /**
         * @return mixed
         */
        public function getSubLayoutContentActions() {
            return $this->subLayoutContentActions;
        }



    }
