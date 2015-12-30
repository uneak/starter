<?php

	namespace ProspectGroupFieldBundle\Handler;


	use ProspectGroupBundle\Entity\ProspectGroup;
    use Symfony\Component\Form\FormInterface;
    use Uneak\FieldBundle\Entity\Field;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\FieldTypeBundle\Field\FieldTypesManager;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Todo\Todo;
    use Uneak\PortoAdminBundle\Blocks\Todo\Todos;
    use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
    use Uneak\RoutesManagerBundle\Helper\MenuHelper;
    use Uneak\RoutesManagerBundle\Routes\FlattenAdminRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ProspectGroupFieldCRUDHandler extends CRUDHandler {


        /**
         * @var ProspectGroupFieldAPIHandler
         */
        protected $apiHandler;

        /**
         * @var MenuHelper
         */
        protected $menuHelper;

        public function __construct(APIHandlerInterface $apiHandler, MenuHelper $menuHelper) {
			parent::__construct($apiHandler);
            $this->menuHelper = $menuHelper;
        }



        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getConfigForm(FlattenRoute $route, $method = Request::METHOD_POST) {

            /** @var $field Field*/
            $field = $route->getParameter('fields')->getParameterSubject();
            $options = $field->getOptions();

            $fieldType = $this->apiHandler->getFieldType($field->getFieldType());
            $form = $this->apiHandler->getForm($fieldType['alias_config'], $options, $method);
            $form->add('o_id', 'hidden', array('mapped' => false, 'data' => $field->getId()));

            return $form;
        }

        public function persistConfig(FormInterface $form) {
            return $this->apiHandler->persistConfig($form);
        }


        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {

            if ($route->hasParameter('groups')) {
                $group = $route->getParameter('groups')->getParameterSubject();
            } else {
                $group = null;
            }

            if ($route->hasParameter('fields')) {
                $field = $route->getParameter('fields')->getParameterSubject();
            } else {
                $field = null;
            }

            /** @var $entity Field */
            $entity = ($field) ? $field : $this->createEntity();
            $entity->setGroup($group);
            $formType = $route->getFormType();
            return $this->apiHandler->getForm($formType, $entity, $method);
        }




        public function getFieldsPanel(FlattenRoute $route) {

            /** @var $group ProspectGroup*/
            $group = $route->getParameter('groups')->getParameterSubject();
            $fields = $this->apiHandler->getFields($group->getSlug());

            $todos = new Todos($group->getSlug());
            /** @var $field Field*/
            foreach ($fields as $field) {

                $html = "<span class='todo-title'>".$field->getLabel()."</span>";
                $html .= " <span class='todo-slug label label-info'>".$field->getSlug()."</span>";
                $html .= " <span class='todo-type label label-danger'>".$field->getType()."</span>";

                $todo = new Todo($field->getSlug(), $html);


                $subjectRoute = $route->getChild('*/subject', array('fields' => $field->getSlug() ) );
                $rowActions = $subjectRoute->getMetaData('_menu');

                $menu = new Menu();
                $menu->setTemplateAlias("block_template_grid_actions_menu");
                $root = $this->menuHelper->createMenu($rowActions, $route, array('fields' => $field->getId()));
                $menu->setRoot($root);

                $todo->setMenu($menu);
                $todos->addTodo($todo);
            }


            $panel = new Panel();
            $panel->setTitle("Liste des champs");
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($todos);

            return $panel;

        }








//		/**
//		 * @param FlattenRoute $route
//		 * @param string $method
//		 * @return FormInterface
//		 */
//		public function getGroupFieldForm(FlattenRoute $route, $method = Request::METHOD_POST) {
//			$client = $route->getParameter('clients')->getParameterSubject();
//			$entity = ($route->hasParameter('fields')) ? $route->getParameter('fields')->getParameterSubject() : $this->createEntity();
//			$entity->setClient($client);
//			$formType = $route->getFormType();
//			return $this->apiHandler->getForm($formType, $entity, $method);
//		}



		private function _qb($gridHelper, $params, $clientID) {
			$qb = $gridHelper->createGridQueryBuilder('Uneak\FieldBundle\Entity\Field', $params);
			$qb->innerjoin('o.client', 'client');
			$qb->andWhere($qb->expr()->eq('client.id', ':clientID'));
			$qb->setParameter('clientID', $clientID);
			return $qb;
		}

		public function getGroupFieldDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {

			$nestedGridRoute = $route->getParent()->getNestedRoute();
			$ids = $nestedGridRoute->getIds();

			$client = $route->getParameter('clients')->getParameterSubject()->getId();

			$gridData = $gridHelper->gridFields($this->_qb($gridHelper, $params, $client), $params, $ids);
			$recordsTotal = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $client));
			$recordsFiltered = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $client));

			$gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

			return array_merge($gridDataArray, array(
				'draw'            => $params["draw"],
				'recordsTotal'    => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
			));


		}


	}