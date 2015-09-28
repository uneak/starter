<?php

	namespace Uneak\PortoAdminBundle\Controller;

    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class LayoutEntityController extends LayoutMainInterfaceController {

        protected $entity = null;
        protected $entityRoute = null;
        protected $entityLayout;
        protected $entityLayoutContent;
        protected $entityLayoutContentBody;
        protected $entityLayoutSidebar;
        protected $entityLayoutToolbar;
        protected $entityLayoutContentActions;




        /**
         * @param null $entity
         */
        public function setEntity($entity) {
            $this->entity = $entity;
        }

        /**
         * @param null $entityRoute
         */
        public function setEntityRoute($entityRoute) {
            $this->entityRoute = $entityRoute;
        }

        /**
         * @param mixed $entityLayout
         */
        public function setEntityLayout($entityLayout) {
            $this->entityLayout = $entityLayout;
        }

        /**
         * @param mixed $entityLayoutContent
         */
        public function setEntityLayoutContent($entityLayoutContent) {
            $this->entityLayoutContent = $entityLayoutContent;
        }

        /**
         * @param mixed $entityLayoutContentBody
         */
        public function setEntityLayoutContentBody($entityLayoutContentBody) {
            $this->entityLayoutContentBody = $entityLayoutContentBody;
        }

        /**
         * @param mixed $entityLayoutSidebar
         */
        public function setEntityLayoutSidebar($entityLayoutSidebar) {
            $this->entityLayoutSidebar = $entityLayoutSidebar;
        }

        /**
         * @param mixed $entityLayoutToolbar
         */
        public function setEntityLayoutToolbar($entityLayoutToolbar) {
            $this->entityLayoutToolbar = $entityLayoutToolbar;
        }

        /**
         * @param mixed $entityLayoutContentActions
         */
        public function setEntityLayoutContentActions($entityLayoutContentActions) {
            $this->entityLayoutContentActions = $entityLayoutContentActions;
        }


	}
