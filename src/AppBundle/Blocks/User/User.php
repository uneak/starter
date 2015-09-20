<?php

    namespace AppBundle\Blocks\User;

    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
    use Uneak\PortoAdminBundle\Blocks\User\User as PortoAdminUser;
    use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

    class User extends PortoAdminUser {

		protected $tokenStorage;
        protected $uploaderHelper;

		public function __construct(TokenStorageInterface $tokenStorage, UploaderHelper $uploaderHelper) {
            parent::__construct();
			$this->tokenStorage = $tokenStorage;
            $this->uploaderHelper = $uploaderHelper;
		}

		public function getUser() {
			return $this->tokenStorage->getToken()->getUser();
		}


	}
