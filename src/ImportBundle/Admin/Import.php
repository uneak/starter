<?php

	namespace ImportBundle\Admin;

	use ImportBundle\Form\ImportCsvType;
	use ImportBundle\Form\ImportDeleteType;
	use ImportBundle\Form\ImportXlsType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

    class Import extends NestedCRUDRoute {

		protected $entity = 'Uneak\ImportBundle\Entity\Import';

		public function initialize() {
			parent::initialize();

			$this->setMetaData('_icon', 'download');
			$this->setMetaData('_label', 'Import');
			$this->setMetaData('_description', 'Gestion des import de prospect');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new_csv'    => '*/csv',
				'new_xls'    => '*/xls',
			));


			$this->setGrantFunction(array($this, "isConstraintGranted"));

		}

		public function isConstraintGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des imports')

				->addRowAction('show', '*/subject/show')
				->addRowAction('delete', '*/subject/delete')

				->addId('imports', 'id')

				->addColumn(array('title' => 'Crée le', 'name' => 'createdAt'))
				->addColumn(array('title' => 'Groupe', 'name' => 'group.label'))
				->addColumn(array('title' => 'Current', 'name' => 'current'))
				->addColumn(array('title' => 'Total', 'name' => 'total'))
				->addColumn(array('title' => 'Status', 'name' => 'status'));

			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('csv');
			$newRoute
				->setPath('csv')
				->setAction('csv')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouvel import CSV')
                ->setRequirement('_method', 'GET|POST')
                ->setFormType(new ImportCsvType())
			;
			$this->addChild($newRoute);



			$newRoute = new NestedAdminRoute('xls');
			$newRoute
				->setPath('xls')
				->setAction('xls')
				->setMetaData('_icon', 'plus-circle')
				->setMetaData('_label', 'Nouvel import Excel')
				->setRequirement('_method', 'GET|POST')
				->setFormType(new ImportXlsType())
			;
			$this->addChild($newRoute);



			$subjectRoute = new NestedEntityRoute('subject');
			$subjectRoute
				->setParameterName($this->getId())
				->setParameterPattern('\d+')
				->setEnabled(false)
				->setMetaData('_menu', array(
					'show'   => '*/subject/show',
					'delete' => '*/subject/delete',
				));
			$this->addChild($subjectRoute);



			$statusRoute = new NestedAdminRoute('status');
			$statusRoute
				->setAction('status')
				->setMetaData('_icon', 'eye')
				->setMetaData('_label', "Status")
				->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($statusRoute);



			$statusRoute = new NestedAdminRoute('stop');
			$statusRoute
				->setAction('stop')
				->setMetaData('_icon', 'times')
				->setMetaData('_label', "arreter l'import")
				->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($statusRoute);



			$editRoute = new NestedAdminRoute('show');
			$editRoute
				->setAction('show')
				->setMetaData('_icon', 'eye')
                ->setMetaData('_label', "Voir l'import")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer l'import")
                ->setMetaData('_description', '{{ entity }}')
				->setFormType(new ImportDeleteType())
			;
			$subjectRoute->addChild($deleteRoute);

		}


	}
