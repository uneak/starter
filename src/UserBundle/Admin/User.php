<?php

	namespace UserBundle\Admin;

	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

	class User extends NestedCRUDRoute {

		protected $entity = 'UserBundle\Entity\User';

		public function initialize() {
			parent::initialize();

			$this->setMetaData('_icon', 'user');
			$this->setMetaData('_label', 'Utilisateurs');
			$this->setMetaData('_description', 'Gestion des utilisateurs');
			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste')
				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')
				->addColumn(array('title' => 'Utilisateur', 'name' => 'username'))
				->addColumn(array('title' => 'Prénom', 'name' => 'firstName'))
				->addColumn(array('title' => 'Nom', 'name' => 'lastName'))
				->addColumn(array('title' => 'Email', 'name' => 'email'));
			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
				->setMetaData('_label', 'Créer');
			$this->addChild($newRoute);


			$subjectRoute = new NestedEntityRoute('subject');
			$subjectRoute
				->setParameterName($this->getId())
				->setParameterPattern('\d+')
				->setEnabled(false)
				->setMetaData('_menu', array(
					'show'   => '*/subject/show',
					'edit'   => '*/subject/edit',
					'delete' => '*/subject/delete',
				));
			$this->addChild($subjectRoute);


			$showRoute = new NestedAdminRoute('show');
			$showRoute
				->setAction('show')
				->setMetaData('_icon', 'eye')
				->setMetaData('_label', 'Show')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
				->setMetaData('_label', 'Edit');
			$subjectRoute->addChild($editRoute);


			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
				->setMetaData('_label', 'Delete');
			$subjectRoute->addChild($deleteRoute);

		}


	}
