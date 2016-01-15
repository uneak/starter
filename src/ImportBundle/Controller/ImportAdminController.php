<?php

	namespace ImportBundle\Controller;

	use Ddeboer\DataImport\Reader\ExcelReader;
	use Symfony\Component\HttpFoundation\File\UploadedFile;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\FieldBundle\Entity\Field;
	use Uneak\FieldDataBundle\FieldData\FieldDataHelper;
	use Uneak\ImportBundle\Entity\Import;
	use Uneak\ImportBundle\Reader\CsvReader;
	use Uneak\PortoAdminBundle\Blocks\Content\Content;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use Uneak\PortoAdminBundle\Blocks\Progress\LinkedProgressBar;
	use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
	use Uneak\PortoAdminBundle\Event\LayoutEntityEvents;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFlashEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormCompleteEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormCreateEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormSubmitEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityLayoutEvent;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ImportAdminController extends LayoutEntityController {


		public function showAction(FlattenRoute $route, Request $request) {

			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();
			$status = $import->getStatus();

			switch ($status) {
				case Import::STATUS_INIT:
					return $this->forward('ImportBundle:ImportAdmin:showInit', array('route' => $route, 'request' => $request));
					break;
				case Import::STATUS_READY:
					return $this->forward('ImportBundle:ImportAdmin:showReady', array('route' => $route, 'request' => $request));
					break;
				case Import::STATUS_PROGRESS:
					return $this->forward('ImportBundle:ImportAdmin:showProgress', array('route' => $route, 'request' => $request));
					break;
				case Import::STATUS_COMPLETE:
					return $this->forward('ImportBundle:ImportAdmin:showComplete', array('route' => $route, 'request' => $request));
					break;
			}

		}




		public function statusAction(FlattenRoute $route, Request $request) {

			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();

			$status = $import->getStatus();
			$statusList = Import::STATUS();
			$statusLabel = $statusList[$import->getStatus()];
			$current = $import->getCurrent();
			$total = $import->getTotal();
			$perc = round($current/$total*100);

			return new JsonResponse(array(
				'status' => $status,
				'statusLabel' => $statusLabel,
				'current' => $current,
				'total' => $total,
				'perc' => $perc,
			));

		}


		public function stopAction(FlattenRoute $route, Request $request) {

			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();

			$importHelper = $this->get('uneak.import.helper');
			$importHelper->stop($import);

			return $this->redirect($route->getChild('*/index')->getRoutePath());

		}


		public function showProgressAction(FlattenRoute $route, Request $request) {

			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();
			$importHelper = $this->get('uneak.import.helper');
			$importHelper->start($import);

			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, function (LayoutEntityLayoutEvent $event) {
				$route = $event->getRoute();
				$layout = $event->getLayout();

				/** @var $import Import */
				$import = $route->getParameter('imports')->getParameterSubject();

				$current = $import->getCurrent();
				$total = $import->getTotal();
				$perc = round($current/$total*100);

				$panel = new Panel();
				$panel->setTitle("Progession");
				$panel->setCollapsed(false);
				$panel->setDismiss(false);
				$panel->setToggle(false);
				$panel->addBlock(new LinkedProgressBar("En cours", "$current / $total", $perc, $route->getChild('*/subject/status', array('imports' => $import->getId()))->getRoutePath()));
				$panel->addBlock(new Content("<a class='stop-process btn btn-danger' href='".$route->getChild('*/subject/stop', array('imports' => $import->getId()))->getRoutePath()."'>Arreter l'import</a>"));

				$layout->getSubLayoutContentBody()->addBlock($panel, 'progress');

				$event->stopPropagation();
			}, false, 10);

			return parent::showAction($route, $request);
		}


		public function showCompleteAction(FlattenRoute $route, Request $request) {

			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, function (LayoutEntityLayoutEvent $event) {
				$route = $event->getRoute();
				$layout = $event->getLayout();

				/** @var $import Import */
				$import = $route->getParameter('imports')->getParameterSubject();

				$current = $import->getCurrent();
				$total = $import->getTotal();

				$message = new Content("Import de $current prospect sur $total terminé");

				$panel = new Panel();
				$panel->setTitle("Terminé");
				$panel->setCollapsed(false);
				$panel->setDismiss(false);
				$panel->setToggle(false);
				$panel->addBlock($message);

				$layout->getSubLayoutContentBody()->addBlock($panel, 'complete');


				$event->stopPropagation();
			}, false, 10);

			return parent::showAction($route, $request);

		}


		public function showReadyAction(FlattenRoute $route, Request $request) {

			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();

			$importHelper = $this->get('uneak.import.helper');
			$importHelper->start($import);

			if ($import->getStatus() == Import::STATUS_READY) {
				ldd('Le process ne peut pas etre lancé');
			}

			return $this->redirect($route->getRoutePath());

		}



		public function showInitAction(FlattenRoute $route, Request $request) {

			$fieldHelper = $this->get('uneak.field.helper');
			$em = $this->get('doctrine.orm.entity_manager');


			/** @var $import Import */
			$import = $route->getParameter('imports')->getParameterSubject();
			$group = $import->getGroup();

			$columns = array();
			foreach ($import->getFields() as $column) {
				$slug = $this->get('slugify')->slugify($column, '_');
				$columns[$slug] = $column;
			}



			$choiceFields = array();
			$dbFields = $fieldHelper->findFieldsByGroup($group);
			/** @var $dbField Field*/
			foreach ($dbFields as $dbField) {
				$choiceFields[$dbField->getId()] = $dbField->getLabel()." [".$dbField->getType()."]";
			}


			$this->on(LayoutEntityEvents::FORM_CREATE, function (LayoutEntityFormCreateEvent $event) use($import, $columns, $choiceFields) {

				$form = $this->createFormBuilder();
				$form->add('o_import', 'hidden', array(
					'data' => $import->getId(),
					'mapped' => false,
				));
				foreach ($columns as $key => $column) {

					$form->add($key, 'choice', array(
						'label' => $column,
						'choices' => array(
							'Associer au champs' => $choiceFields,
							'Créer un champ' => FieldDataHelper::ALIAS(),
							'Action' => array(
								'' => 'Ne pas utiliser',
							)
						),
						'data' => '',
						'required' => true,
						'mapped' => true,
					));
				}
				$form = $form->getForm();
				$event->setForm($form);

				$event->stopPropagation();
			}, false, 10);


			$this->on(LayoutEntityEvents::FORM_INITIALIZE, function (LayoutEntityFormEvent $event) {
				$form = $event->getForm();
				$form->add('submit', 'submit', array('label' => 'Proceed'));

				$event->stopPropagation();
			}, false, 10);


			$this->on(LayoutEntityEvents::FORM_SUCCESS, function (LayoutEntityFormSubmitEvent $event) use($fieldHelper, $em, $group, $columns) {
				$form = $event->getForm();

				$data = $form->getData();
				$fields = array();
				foreach ($data as $key => $value) {

					if (is_numeric($value)) {
						$fields[$key] = intval($value);

					} else if ($value == '') {
						$fields[$key] = null;

					} else {
						$field = $fieldHelper->createField($group, $columns[$key], $value, 0, $key);
						$fieldHelper->saveField($field);
						$fields[$key] = $field->getId();
					}

				}

				$oImport = $form->get('o_import')->getData();
				$import = $em->getRepository('UneakImportBundle:Import')->find($oImport);
				$import->setFields(array_values($fields));
				$import->setStatus(Import::STATUS_READY);
				$em->flush();

				$event->setEntity($import);

				$event->stopPropagation();
			}, false, 10);


			$this->on(LayoutEntityEvents::FLASH_SUCCESS, function (LayoutEntityFlashEvent $event) {
				$flash = array(
					'type' => 'info',
					'title' => 'Import',
					'text' => "Champs de l'import associés",
					'shadow' => true,
					'stack' => 'stack-bar-bottom'
				);
				$event->setFlash($flash);

				$event->stopPropagation();
			}, false, 10);


			return parent::editAction($route, $request);
		}




		public function csvAction(FlattenRoute $route, Request $request) {

			$this->on(LayoutEntityEvents::FORM_INITIALIZE, function (LayoutEntityFormEvent $event) {
				$form = $event->getForm();
				$form->add('submit', 'submit', array('label' => 'Importer'));
				$event->stopPropagation();
			}, false, 10);

			$this->on(LayoutEntityEvents::FORM_SUCCESS, function (LayoutEntityFormSubmitEvent $event) {
				$form = $event->getForm();
				$crudHandler = $event->getCrudHandler();

				$fileField = $form->get('file')->getData();
				if ($fileField) {
					$content = file_get_contents($fileField);
				} else {
					$content = $form->get('content')->getData();
				}

				$reader = new CsvReader($content, $form->get('rowDelimiter')->getData(), $form->get('delimiter')->getData());
				$entity = new Import($form->get('group')->getData(), $reader->getColumnHeaders(), $reader->getArrayCopy());
				$entity = $crudHandler->persistImport($entity);
				$event->setEntity($entity);

				$event->stopPropagation();
			}, false, 10);


			$this->on(LayoutEntityEvents::FORM_COMPLETE, function (LayoutEntityFormCompleteEvent $event) {
				/** @var $entity Import */
				$entity = $event->getEntity();
				$route = $event->getRoute();
				$url = $route->getChild('*/subject/show', array('imports' => $entity->getId()))->getRoutePath();
				$event->setRedirectUrl($url);

				$event->stopPropagation();
			}, false, 10);

			return parent::newAction($route, $request);
		}




		public function xlsAction(FlattenRoute $route, Request $request) {

			$this->on(LayoutEntityEvents::FORM_INITIALIZE, function (LayoutEntityFormEvent $event) {
				$form = $event->getForm();
				$form->add('submit', 'submit', array('label' => 'Importer'));
				$event->stopPropagation();
			}, false, 10);

			$this->on(LayoutEntityEvents::FORM_SUCCESS, function (LayoutEntityFormSubmitEvent $event) {
				$form = $event->getForm();
				$crudHandler = $event->getCrudHandler();

				/** @var $fileField UploadedFile */
				$fileField = $form->get('file')->getData();
				$headerRowNumber = $form->get('headerRowNumber')->getData();
				$activeSheet = $form->get('activeSheet')->getData();

				$reader = new ExcelReader($fileField->openFile(), $headerRowNumber, $activeSheet);

				$arrayCopy = array();
				foreach($reader as $row) {
					$rowCopy = array();
					foreach ($row as $value) {
						$rowCopy[] = $value;
					}
					$arrayCopy[] = $rowCopy;
				}

				$entity = new Import($form->get('group')->getData(), array_values($reader->getColumnHeaders()), $arrayCopy);

				$entity = $crudHandler->persistImport($entity);
				$event->setEntity($entity);

				$event->stopPropagation();
			}, false, 10);


			$this->on(LayoutEntityEvents::FORM_COMPLETE, function (LayoutEntityFormCompleteEvent $event) {
				/** @var $entity Import */
				$entity = $event->getEntity();
				$route = $event->getRoute();
				$url = $route->getChild('*/subject/show', array('imports' => $entity->getId()))->getRoutePath();
				$event->setRedirectUrl($url);

				$event->stopPropagation();
			}, false, 10);

			return parent::newAction($route, $request);
		}



	}
