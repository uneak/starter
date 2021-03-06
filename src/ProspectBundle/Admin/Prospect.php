<?php

	namespace ProspectBundle\Admin;

	use ProspectBundle\Form\ProspectDeleteType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;
    use Uneak\RoutesManagerBundle\Routes\NestedRoute;

    class Prospect extends NestedCRUDRoute {

		protected $entity = 'Uneak\ProspectBundle\Entity\Prospect';

		public function initialize() {
			parent::initialize();

//            $this->setFormType(new ProspectType());

			$this->setMetaData('_icon', 'male');
			$this->setMetaData('_label', 'Prospects');
			$this->setMetaData('_description', 'Gestion des prospects');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));


			$this->setGrantFunction(array($this, "isProspectGranted"));

		}

		public function isProspectGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des prospects')

				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')

				->addId($this->getId(), 'id')
//				->addId('groups', 'group.id')

                ->addColumn(array('title' => 'ID', 'name' => 'id'))
                ->addColumn(array('title' => 'Création', 'name' => 'createdAt'))
                ->addColumn(array('title' => 'Identifiant', 'name' => 'code'))
//				->addColumn(array('title' => 'Groupe', 'name' => 'group.label'))
//				->addColumn(array('title' => 'Source', 'name' => 'source'))
				;

			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouveau prospect')
			;
			$this->addChild($newRoute);


            $importRoute = new NestedRoute('import');
            $importRoute
                ->setPath('import')
                ->setAction('import')
                ->setEnabled(false)
            ;
            $this->addChild($importRoute);



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
			    ->setMetaData('_label', "Voir le prospect")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer le prospect")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer le prospect")
                ->setMetaData('_description', '{{ entity }}')
				->setFormType(new ProspectDeleteType());
			$subjectRoute->addChild($deleteRoute);

		}


	}
