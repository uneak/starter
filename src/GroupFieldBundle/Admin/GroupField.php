<?php

	namespace GroupFieldBundle\Admin;

	use GroupFieldBundle\Form\GroupFieldDeleteType;
	use GroupFieldBundle\Form\GroupFieldType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

    class GroupField extends NestedCRUDRoute {

		protected $entity = 'GroupFieldBundle\Entity\GroupField';

		public function initialize() {
			parent::initialize();

            $this->setFormType(new GroupFieldType());

			$this->setMetaData('_icon', 'briefcase');
			$this->setMetaData('_image', 'imageFile');
			$this->setMetaData('_label', 'GroupField');
			$this->setMetaData('_description', 'Gestion des fields');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));


			$this->setGrantFunction(array($this, "isGroupFieldGranted"));

		}

		public function isGroupFieldGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des fields')

				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')

				->addId('fields', 'id')

				->addColumn(array('title' => 'Identifiant', 'name' => 'id'))
				->addColumn(array('title' => 'Groupe', 'name' => 'group.label'))
			;
			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouveau field')
//                ->setFormType(new GroupFieldNewType());
			;
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
			    ->setMetaData('_label', "Voir le field")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer le field")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer le field")
                ->setMetaData('_description', '{{ entity }}')
				->setFormType(new GroupFieldDeleteType());
			$subjectRoute->addChild($deleteRoute);

		}


	}
