<?php

	namespace UserBundle\Security;

	use Doctrine\ORM\EntityManager;
    use FOS\UserBundle\Model\UserManagerInterface;
    use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
	use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
    use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
    use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
	use Symfony\Component\HttpFoundation\File\File;
	use Symfony\Component\HttpFoundation\File\UploadedFile;
	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
    use UserBundle\Entity\User;


	class UserProvider implements UserProviderInterface, AccountConnectorInterface, OAuthAwareUserProviderInterface {

		protected $em;
		protected $repository;
        protected $userManager;
        protected $accessor;

		public function __construct(EntityManager $em, UserManagerInterface $userManager) {
			$this->em = $em;
			$this->repository = $em->getRepository("UserBundle:User");
            $this->userManager = $userManager;
            $this->accessor    = PropertyAccess::createPropertyAccessor();
		}

		/**
		 * {@inheritdoc}
		 */
		public function loadUserByUsername($username) {
            $user = $this->findUser($username);

            if (!$user) {
                throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
            }

            return $user;
		}



        /**
         * {@inheritdoc}
         */
        public function refreshUser(UserInterface $user) {

            if (!$this->supportsClass(get_class($user))) {
                throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', $this->userManager->getClass(), get_class($user)));
            }

            if (null === $reloadedUser = $this->userManager->findUserBy(array('id' => $user->getId()))) {
                throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
            }

            return $reloadedUser;
        }



		/**
		 * {@inheritdoc}
		 */
		public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
			$resourceOwnerName = $response->getResourceOwner()->getName();
			$id = $response->getUsername();
			$realName = $response->getRealName();
			$user = null;


			ldd($_REQUEST);

			if ($resourceOwnerName == "facebook") {
                $user = $this->userManager->findUserBy(array('facebookId' => $id));
                if (null === $user) {
                    throw new AccountNotLinkedException(sprintf("User '%s' not found.", $realName));
                }

			} else if ($resourceOwnerName == "google") {
				$user = $this->userManager->findUserBy(array('googleId' => $id));
				if (null === $user) {
					throw new AccountNotLinkedException(sprintf("User '%s' not found.", $realName));
				}

			} else if ($resourceOwnerName == "twitter") {
				$user = $this->userManager->findUserBy(array('twitterId' => $id));
				if (null === $user) {
					throw new AccountNotLinkedException(sprintf("User '%s' not found.", $realName));
				}

			}

			return $user;
		}




		/**
		 * {@inheritDoc}
		 */
		public function disconnect(UserInterface $user, $resourceOwnerName) {

			if (!$user instanceof User) {
				throw new UnsupportedUserException(sprintf('Expected an instance of UserBundle\Model\User, but got "%s".', get_class($user)));
			}

			if ($resourceOwnerName == "facebook") {
				$property = "facebookId";

				if (!$this->accessor->isWritable($user, $property)) {
					throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
				}

				$user->setFacebookId(null);
				$this->userManager->updateUser($user);


			} else if ($resourceOwnerName == "google") {
				$property = "googleId";

				if (!$this->accessor->isWritable($user, $property)) {
					throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
				}

				$user->setGoogleId(null);
				$this->userManager->updateUser($user);


			} else if ($resourceOwnerName == "twitter") {
				$property = "twitterId";

				if (!$this->accessor->isWritable($user, $property)) {
					throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
				}

				$user->setTwitterId(null);
				$this->userManager->updateUser($user);

			}


		}





		/**
		 * {@inheritDoc}
		 */
		public function connect(UserInterface $user, UserResponseInterface $response) {

            if (!$user instanceof User) {
                throw new UnsupportedUserException(sprintf('Expected an instance of UserBundle\Model\User, but got "%s".', get_class($user)));
            }

			$resourceOwnerName = $response->getResourceOwner()->getName();
			$id = $response->getUsername();


            if ($resourceOwnerName == "facebook") {
                $property = "facebookId";

                if (!$this->accessor->isWritable($user, $property)) {
                    throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
                }

                if (null !== $previousUser = $this->userManager->findUserBy(array("facebookId" => $id))) {
                    $previousUser->setFacebookId(null);
                    $this->userManager->updateUser($previousUser);
                }

                $user->setFacebookId($id);
                $this->userManager->updateUser($user);


            } else if ($resourceOwnerName == "google") {
				$property = "googleId";

				if (!$this->accessor->isWritable($user, $property)) {
					throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
				}

				if (null !== $previousUser = $this->userManager->findUserBy(array("googleId" => $id))) {
					$previousUser->setGoogleId(null);
					$this->userManager->updateUser($previousUser);
				}

				$user->setGoogleId($id);
				$this->userManager->updateUser($user);


			} else if ($resourceOwnerName == "twitter") {
				$property = "twitterId";

				if (!$this->accessor->isWritable($user, $property)) {
					throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
				}

				if (null !== $previousUser = $this->userManager->findUserBy(array("twitterId" => $id))) {
					$previousUser->setTwitterId(null);
					$this->userManager->updateUser($previousUser);
				}

				$user->setTwitterId($id);
				$this->userManager->updateUser($user);

			}


		}



        protected function findUser($username)
        {
            return $this->userManager->findUserByUsername($username);
        }

		/**
		 * {@inheritdoc}
		 */
		public function supportsClass($class) {
			return $class === 'UserBundle\\Entity\\User' || is_subclass_of($class, 'UserBundle\\Entity\\User');
		}
	}
