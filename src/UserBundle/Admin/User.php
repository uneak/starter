<?php

	namespace UserBundle\Admin;

	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;
    use UserBundle\Form\UserNewType;
    use UserBundle\Form\UserType;

    class User extends NestedCRUDRoute {

		protected $entity = 'UserBundle\Entity\User';

		public function initialize() {
			parent::initialize();

            $this->setFormType(new UserType());

			$this->setMetaData('_icon', 'user');
			$this->setMetaData('_image', 'imageFile');
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
				->setMetaData('_label', 'Liste des utilisateurs')

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
                ->setMetaData('_label', 'Nouvel utilisateur')
                ->setFormType(new UserNewType());
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
			    ->setMetaData('_label', "Voir l'utilisateur")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer l'utilisateur")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);


			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer l'utilisateur")
                ->setMetaData('_description', '{{ entity }}');
			$subjectRoute->addChild($deleteRoute);

		}


	}
