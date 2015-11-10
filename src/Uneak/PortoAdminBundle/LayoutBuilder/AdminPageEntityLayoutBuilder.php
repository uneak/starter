<?php

    namespace Uneak\PortoAdminBundle\LayoutBuilder;

    use Symfony\Component\Form\FormFactoryInterface;
    use Symfony\Component\Form\FormInterface;
    use Symfony\Component\Form\FormView;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\PropertyAccess\PropertyAccess;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class AdminPageEntityLayoutBuilder extends AdminPageSubLayoutBuilder {

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
        


        public function buildEntityLayout(FlattenRoute $route) {
            $twig = new \Twig_Environment(new \Twig_Loader_Array(array()));


            $this->breadcrumb->setFlattenRoute($route);


            $menu = $this->blocksManager->getBlock("block_flattenroute_menu")->setFlattenRoute($route);

            $this->subLayoutSidebar->addWidget("menu", $menu, false, 999999);

            $this->layoutContentHeader->setTitle($route->getMetaData('_label'));


            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }
            $entity = ($entityRoute) ? $entityRoute->getParameterSubject() : null;

            if ($entityRoute) {

                $this->subLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_SCROLL);

                $label = $twig->createTemplate($route->getMetaData('_label'))->render(array('entity' => $entity));
                $description = $twig->createTemplate($route->getMetaData('_description'))->render(array('entity' => $entity));

                $this->subLayoutContent->setTitle($label);
                $this->subLayoutContent->setSubtitle($description);

                $accessor = PropertyAccess::createPropertyAccessor();
                $photoFile = ($route->getMetaData('_image') && $accessor->isReadable($entity, $route->getMetaData('_image'))) ? $this->uploaderHelper->asset($entity, $route->getMetaData('_image')) : null;

                if ($photoFile) {
                    $photo = new Photo();
                    $photo->setPhoto($photoFile);
                    $this->subLayoutSidebar->addWidget("photo", $photo, false, 9999999);
                }

            } else {

                $this->subLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_FIXED);
                $this->subLayoutContent->setTitle($route->getMetaData('_label'));
                $this->subLayoutContent->setSubtitle($route->getMetaData('_description'));
            }
        }


        public function buildGridPage(FlattenRoute $route) {

            $this->subLayoutContent->setTemplateType(EntityContent::TEMPLATE_TYPE_FIXED);

            $search = new Search();
            $search->setInputName("datatable_search");
            $this->subLayoutContent->addWidget("search", $search);

            $factory = $this->menuHelper->getFactory();
            $root = $factory->createItem('root');

            $tableShow = $factory->createItem('table_show', array(
                'label' => 'Afficher',
                'icon' => 'chevron-down',
            ));
            $root->addChild($tableShow);
            $showRow = array("100", "50", "25", "10");
            foreach ($showRow as $rowNumber) {
                $tableShow->addChild($factory->createItem('row_show_'.$rowNumber, array(
                    'label' => 'afficher '.$rowNumber.' éléments',
                    'linkAttributes' => array(
                        'class' => 'table-row-number',
                        'data-value' => $rowNumber,
                    )
                )));
            }

            $this->subLayoutContentActions->setRoot($root);

            $gridNested = $route->getNestedRoute();
            $datatable = new Datatable();
            $datatable->setSearchInput('#'.$search->getInputName());
            $datatable->setAjax($route->getChild('_grid')->getRoutePath());
            $datatable->setColumns($gridNested->getColumns());

            $this->subLayoutContentBody->addBlock($datatable, 'datatable');
        }



        public function buildFormPage(FormView $formView, $title) {

            $formBlock = new Form($formView);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle($title);
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $this->subLayoutContentBody->addBlock($panel, 'form');

            return $formView;
        }



	}
