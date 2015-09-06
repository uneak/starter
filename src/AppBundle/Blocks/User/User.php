<?php

    namespace AppBundle\Blocks\User;

    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
    use Uneak\PortoAdminBundle\Blocks\User\User as PortoAdminUser;

	class User extends PortoAdminUser {

		protected $tokenStorage;

		public function __construct(TokenStorageInterface $tokenStorage) {
            parent::__construct();
			$this->tokenStorage = $tokenStorage;
		}

		public function getUser() {
			return $this->tokenStorage->getToken()->getUser();
		}


	}
