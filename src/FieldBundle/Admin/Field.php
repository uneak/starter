<?php

	namespace FieldBundle\Admin;

	use FieldBundle\Form\FieldDeleteType;
	use FieldBundle\Form\FieldType;
	use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;

    class Field extends NestedCRUDRoute {

		protected $entity = 'Uneak\FieldBundle\Entity\Field';

		public function initialize() {
			parent::initialize();

            $this->setFormType(new FieldType());

			$this->setMetaData('_icon', 'terminal');
			$this->setMetaData('_label', 'Champs');
			$this->setMetaData('_description', 'Gestion des champs');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));


			$this->setGrantFunction(array($this, "isGroupFieldGranted"));


		}

		public function isGroupFieldGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}

		public function isFieldTypeGranted($attribute, $flattenRoute, $user = null) {
            return (!!$flattenRoute->getParameter('fields')->getParameterSubject()->getFieldType());
		}


		protected function buildCRUD() {

			$indexRoute = new NestedAdminRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des champs')
			;
			$this->addChild($indexRoute);



            $fieldSortRoute = new NestedAdminRoute('sort');
            $fieldSortRoute
                ->setAction('sort')
                ->setMetaData('_icon', 'eye')
                ->setMetaData('_label', "reorder")
                ->setMetaData('_description', '')
                ->setRequirement('_method', 'GET|POST')
            ;
            $indexRoute->addChild($fieldSortRoute);


            $fieldCheckRoute = new NestedAdminRoute('check');
            $fieldCheckRoute
                ->setAction('check')
                ->setMetaData('_icon', 'eye')
                ->setMetaData('_label', "check")
                ->setMetaData('_description', '')
                ->setRequirement('_method', 'GET|POST')
            ;
            $indexRoute->addChild($fieldCheckRoute);




			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouveau champ')
			;
			$this->addChild($newRoute);


			$subjectRoute = new NestedEntityRoute('subject');
			$subjectRoute
				->setParameterName($this->getId())
				->setParameterPattern('\d+')
				->setEnabled(false)
				->setMetaData('_menu', array(
					'config'   => '*/subject/config',
					'constraints'   => '*/subject/constraints/index',
					'show'   => '*/subject/show',
					'edit'   => '*/subject/edit',
					'delete' => '*/subject/delete',
				));
			$this->addChild($subjectRoute);

            $configRoute = new NestedAdminRoute('config');
            $configRoute
                ->setAction('config')
                ->setMetaData('_icon', 'cog')
                ->setMetaData('_label', "configurer le champ")
                ->setMetaData('_description', '{{ entity }}')
                ->setRequirement('_method', 'GET|POST')
                ->setGrantFunction(array($this, "isFieldTypeGranted"));
            $subjectRoute->addChild($configRoute);

//            $constraintRoute = new NestedAdminRoute('constraint');
//            $constraintRoute
//                ->setAction('constraint')
//                ->setMetaData('_icon', 'user')
//                ->setMetaData('_label', "Contraintes de validation")
//                ->setMetaData('_description', '{{ entity }}')
//                ->setRequirement('_method', 'GET|POST');
//            $subjectRoute->addChild($constraintRoute);


			$showRoute = new NestedAdminRoute('show');
			$showRoute
				->setAction('show')
				->setMetaData('_icon', 'eye')
			    ->setMetaData('_label', "Voir le champ")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer le champ")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);

			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer le champ")
                ->setMetaData('_description', '{{ entity }}')
				->setFormType(new FieldDeleteType());
			$subjectRoute->addChild($deleteRoute);

		}


	}
