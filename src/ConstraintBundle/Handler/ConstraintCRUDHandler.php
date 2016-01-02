<?php

	namespace ConstraintBundle\Handler;


	use Symfony\Component\Form\FormInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\FieldBundle\Entity\Field;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Todo\Todo;
    use Uneak\PortoAdminBundle\Blocks\Todo\Todos;
    use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ConstraintCRUDHandler extends CRUDHandler {


        /**
         * @var MenuHelper
         */
        private $menuHelper;

        public function __construct(APIHandlerInterface $apiHandler, MenuHelper $menuHelper) {
			parent::__construct($apiHandler);
            $this->menuHelper = $menuHelper;
        }


        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {

            /** @var $field Field*/
            $field = $route->getParameter('fields')->getParameterSubject();

            if ($route->getSlug() == "edit") {
                $idOrType = $route->getParameter('constraints')->getParameterValue();
            } else {
                $idOrType = $route->getParameter('typeconstraint')->getParameterValue();
            }

            return $this->apiHandler->getForm($idOrType, $field, $method);
        }



        public function getConstraintsPanel(FlattenRoute $route) {

            /** @var $field Field*/
            $field = $route->getParameter('fields')->getParameterSubject();

            $constraints = $this->apiHandler->getConstraints($field);

            $todos = new Todos($field->getSlug());
            foreach ($constraints as $constraint) {
                $constraintData = $this->apiHandler->getConstraintData($constraint['alias']);

                $html = "<span class='todo-title'>".$constraintData['label']."</span>";
                $todo = new Todo($constraint['id'], $html);

                $subjectRoute = $route->getChild('*/subject', array('constraints' => $constraint['id'] ) );
                $rowActions = $subjectRoute->getMetaData('_menu');

                $menu = new Menu();
                $menu->setTemplateAlias("block_template_grid_actions_menu");
                $root = $this->menuHelper->createMenu($rowActions, $route, array('constraints' => $constraint['id']));
                $menu->setRoot($root);

                $todo->setMenu($menu);
                $todos->addTodo($todo);
            }


            $panel = new Panel();
            $panel->setTitle("Liste des contraintes");
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($todos);

            return $panel;

        }




	}