<?php

	namespace ConstraintBundle\Admin;

	use ConstraintBundle\Form\ConstraintDeleteType;
	use ConstraintBundle\Form\ConstraintType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

    class Constraint extends NestedCRUDRoute {

		protected $entity = 'Uneak\FieldBundle\Entity\Field';

		public function initialize() {
			parent::initialize();


			$this->setMetaData('_icon', 'briefcase');
			$this->setMetaData('_label', 'Contraintes');
			$this->setMetaData('_description', 'Gestion des contraintes de validation');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
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
				->setMetaData('_label', 'Liste des contraintes')

				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')

				->addId('constraints', 'id')

				->addColumn(array('title' => 'Id', 'name' => 'id'))
				->addColumn(array('title' => 'Code', 'name' => 'slug'))
				->addColumn(array('title' => 'Titre', 'name' => 'label'));

			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouvelle contrainte')
                ->setRequirement('_method', 'GET|POST')
                ->setFormType('constraints_selector')
			;
			$this->addChild($newRoute);



            $typeRoute = new NestedEntityRoute('type');
            $typeRoute
                ->setParameterName('typeconstraint')
                ->setEnabled(false)
            ;
            $this->addChild($typeRoute);


            $newTypeRoute = new NestedAdminRoute('new');
            $newTypeRoute
                ->setPath('new')
                ->setAction('typeNew')
                ->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouvelle contrainte')
            ;
            $typeRoute->addChild($newTypeRoute);





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
			    ->setMetaData('_label', "Voir la contrainte")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer la contrainte")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer la contrainte")
                ->setMetaData('_description', '{{ entity }}');
//				->setFormType(new ConstraintDeleteType());
			$subjectRoute->addChild($deleteRoute);

		}


	}
