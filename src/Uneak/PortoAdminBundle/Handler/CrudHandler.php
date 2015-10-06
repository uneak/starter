<?php

	namespace Uneak\PortoAdminBundle\Handler;


	use Acme\BlogBundle\Exception\InvalidFormException;
	use Symfony\Component\Form\FormFactoryInterface;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Helper\MenuHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class CrudHandler {


		/**
		 * @var \Symfony\Component\Form\FormFactoryInterface
		 */
		private $formFactory;
		/**
		 * @var \Uneak\BlocksManagerBundle\Blocks\BlockBuilder
		 */
		private $blockBuilder;
		/**
		 * @var \Uneak\RoutesManagerBundle\Helper\GridHelper
		 */
		private $gridHelper;
		/**
		 * @var \Uneak\RoutesManagerBundle\Helper\MenuHelper
		 */
		private $menuHelper;


		public function __construct(FormFactoryInterface $formFactory, BlockBuilder $blockBuilder, GridHelper $gridHelper, MenuHelper $menuHelper) {
			$this->formFactory = $formFactory;
			$this->blockBuilder = $blockBuilder;
			$this->gridHelper = $gridHelper;
			$this->menuHelper = $menuHelper;
		}


		public function getRouteForm(FlattenRoute $route, $method = "PUT") {
			$entityRoute = $route;
			while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
				$entityRoute = $entityRoute->getParent();
			}
			$entity = ($entityRoute) ? $entityRoute->getParameterSubject() : null;
			$formType = $route->getFormType();

			return $this->getForm($formType, $entity, $method);
		}


		public function getForm($formType, $entity, $method = "PUT") {
			return $this->formFactory->create($formType, $entity, array('method' => $method));
		}


		public function submitForm(FormInterface $form, array $parameters) {
			$form->submit($parameters, $form->getConfig()->getMethod() !== 'PATCH');
			return $form->isValid();
		}


		public function persistEntity(FormInterface $form) {
			$entity = $form->getData();
//			$this->em->persist($entity);
//			$this->em->flush($entity);

			return $entity;
		}


		public function processForm(FormInterface $form, array $parameters) {
			$isValid = $this->submitForm($form, $parameters);
			if ($isValid) {
				$entity = $form->getData();
				$this->persistEntity($entity);
				return $entity;
			}
			throw new InvalidFormException('Invalid submitted data', $form);
		}




		public function getDatatableJSon(FlattenRoute $route, Request $request) {

			$entityClass = $route->getCRUD()->getEntity();

			$params = $request->query->all();
			$gridData = $this->gridHelper->gridFields($this->gridHelper->createGridQueryBuilder($entityClass, $params), $params);
			$recordsTotal = $this->gridHelper->gridFieldsCount($this->gridHelper->createGridQueryBuilder($entityClass, $params));
			$recordsFiltered = $this->gridHelper->gridFieldsCount($this->gridHelper->createGridQueryBuilder($entityClass, $params));



			$data = array();
			foreach ($gridData as $object) {
				$row = array();
				foreach ($params['columns'] as $columns) {
					if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {
						$value = $object[str_replace(".", "_", $columns['name'])];
						if ($value instanceof \DateTime) {
							$value = $value->format('d/m/Y H:m:s');
						}
						$row[$columns['data']] = $value;
					} else {
						$row[$columns['data']] = "";
					}
				}
				$row['DT_RowId'] = $object['DT_RowId'];



				$menu = new Menu();
				$menu->setTemplateAlias("block_template_grid_actions_menu");

				$rowActions = $route->getParent()->getNestedRoute()->getRowActions();
				$root = $this->menuHelper->createMenu($rowActions, $route, array($row['DT_RowId']));
				$menu->setRoot($root);

				$this->blockBuilder->addBlock("row_actions", $menu);
				$row['_actions'] = "A B C";
					//$this->renderView("<div class='menu-bullets'>{{ renderBlock('row_actions') }}</div>");


				array_push($data, $row);
			}


			return new JsonResponse(array(
				'draw'            => $params["draw"],
				'recordsTotal'    => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
				'data'            => $data,
			));
		}




	}