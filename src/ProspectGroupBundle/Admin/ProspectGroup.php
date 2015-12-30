<?php

	namespace ProspectGroupBundle\Admin;

	use ProspectGroupBundle\Form\ProspectGroupDeleteType;
	use ProspectGroupBundle\Form\ProspectGroupType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

    class ProspectGroup extends NestedCRUDRoute {

		protected $entity = 'ProspectGroupBundle\Entity\ProspectGroup';

		public function initialize() {
			parent::initialize();

            $this->setFormType(new ProspectGroupType());

			$this->setMetaData('_icon', 'briefcase');
			$this->setMetaData('_image', 'imageFile');
			$this->setMetaData('_label', 'Groupe');
			$this->setMetaData('_description', 'Gestion des groupes');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));


			$this->setGrantFunction(array($this, "isProspectGroupGranted"));

		}

		public function isProspectGroupGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des groups')

				->addId('groups', 'id')


                ->addRowAction('fields', '*/subject/fields/index')
                ->addRowAction('prospects', '*/subject/prospects/index')
				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')

				->addColumn(array('title' => 'Code', 'name' => 'slug'))
				->addColumn(array('title' => 'Titre', 'name' => 'label'));

			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouveau group')
//                ->setFormType(new ProspectGroupNewType());
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
					'field' => '*/subject/fields/index',
					'prospect' => '*/subject/prospects/index',
				));
			$this->addChild($subjectRoute);


			$showRoute = new NestedAdminRoute('show');
			$showRoute
				->setAction('show')
				->setMetaData('_icon', 'eye')
			    ->setMetaData('_label', "Voir le group")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer le group")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer le group")
                ->setMetaData('_description', '{{ entity }}')
				->setFormType(new ProspectGroupDeleteType());
			$subjectRoute->addChild($deleteRoute);

		}


	}
