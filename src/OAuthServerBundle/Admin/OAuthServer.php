<?php

	namespace OAuthServerBundle\Admin;

	use OAuthServerBundle\Form\OAuthServerCreateType;
    use OAuthServerBundle\Form\OAuthServerType;
    use Uneak\RoutesManagerBundle\Routes\NestedAdminRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedCRUDRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\NestedGridRoute;


    class OAuthServer extends NestedCRUDRoute {

		protected $entity = 'OAuthServerBundle\Entity\Client';

		public function initialize() {
			parent::initialize();

            $this->setFormType(new OAuthServerType());

			$this->setMetaData('_icon', 'link');
			$this->setMetaData('_image', 'imageFile');
			$this->setMetaData('_label', 'Client OAuth');
			$this->setMetaData('_description', 'Gestion des clients OAuth');

			$this->setMetaData('_menu', array(
				'index'  => '*/index',
				'new'    => '*/new',
			));


			$this->setGrantFunction(array($this, "isUserGranted"));

		}

		public function isUserGranted($attribute, $flattenRoute, $user = null) {
			return (in_array("ROLE_SUPER_ADMIN", $user->getRoles()));
		}


		protected function buildCRUD() {

			$indexRoute = new NestedGridRoute('index');
			$indexRoute
				->setPath('')
				->setAction('index')
				->setMetaData('_icon', 'list')
				->setMetaData('_label', 'Liste des clients OAuth')

				->addRowAction('show', '*/subject/show')
				->addRowAction('edit', '*/subject/edit')
				->addRowAction('delete', '*/subject/delete')

				->addColumn(array('title' => 'label', 'name' => 'label'))
				;


			$this->addChild($indexRoute);


			$newRoute = new NestedAdminRoute('new');
			$newRoute
				->setPath('new')
				->setAction('new')
				->setMetaData('_icon', 'plus-circle')
                ->setMetaData('_label', 'Nouveau client OAuth');
			$this->addChild($newRoute);


			$subjectRoute = new NestedEntityRoute('subject');
			$subjectRoute
				->setParameterName('oauthserver')
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
			    ->setMetaData('_label', "Voir le client OAuth")
			    ->setMetaData('_description', '{{ entity }}')
				->setRequirement('_method', 'GET');
			$subjectRoute->addChild($showRoute);


			$editRoute = new NestedAdminRoute('edit');
			$editRoute
				->setAction('edit')
				->setMetaData('_icon', 'edit')
                ->setMetaData('_label', "Editer le client OAuth")
                ->setMetaData('_description', '{{ entity }}');

			$subjectRoute->addChild($editRoute);


			$deleteRoute = new NestedAdminRoute('delete');
			$deleteRoute
				->setAction('delete')
				->setMetaData('_icon', 'times')
                ->setMetaData('_label', "Supprimer le client OAuth")
                ->setMetaData('_description', '{{ entity }}');
			$subjectRoute->addChild($deleteRoute);

		}


	}
