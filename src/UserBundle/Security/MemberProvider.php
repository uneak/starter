<?php

	namespace UserBundle\Security;

	use Doctrine\ORM\EntityManager;
    use FOS\UserBundle\Model\UserManagerInterface;
    use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
	use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
    use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
    use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
    use UserBundle\Entity\Member;
    use UserBundle\Entity\User;


	class MemberProvider implements UserProviderInterface, AccountConnectorInterface, OAuthAwareUserProviderInterface {

		protected $em;
		protected $repository;
        protected $userManager;
        protected $accessor;

		public function __construct(EntityManager $em, UserManagerInterface $userManager) {
			$this->em = $em;
			$this->repository = $em->getRepository("UserBundle:Member");
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
			$response = $response->getResponse();
            $user = null;

			if ($resourceOwnerName == "facebook") {

                $user = $this->userManager->findUserBy(array('facebookId' => $response['id']));
                if (null === $user) {
                    throw new AccountNotLinkedException(sprintf("User '%s' not found.", $response['first_name']." ".$response['last_name']));
                }


//                if (null === $user = $this->userManager->findUserBy(array('facebookId' => $response['id']))) {
//					throw new UsernameNotFoundException(sprintf("User '%s' not found.", $response['first_name']." ".$response['last_name']));
////					$user = new Member();
////					$user->setFacebookId($response['id']);
////					$user->setFirstName($response['first_name']);
////					$user->setLastName($response['last_name']);
////					$user->setEmail($response['email']);
////					$user->setUsername($response['email']);
////					$this->em->persist($user);
////					$this->em->flush();
//				}
			}

//            ldd('user');

			return $user;
		}


		/**
		 * {@inheritDoc}
		 */
		public function connect(UserInterface $user, UserResponseInterface $response) {

            if (!$user instanceof Member) {
                throw new UnsupportedUserException(sprintf('Expected an instance of UserBundle\Model\Member, but got "%s".', get_class($user)));
            }


            $resourceOwnerName = $response->getResourceOwner()->getName();
            $response = $response->getResponse();

            if ($resourceOwnerName == "facebook") {
                $property = "facebookId";

                if (!$this->accessor->isWritable($user, $property)) {
                    throw new \RuntimeException(sprintf("Class '%s' must have defined setter method for property: '%s'.", get_class($user), $property));
                }

                if (null !== $previousUser = $this->userManager->findUserBy(array("facebookId" => $response['id']))) {
                    $previousUser->setFacebookId(null);
                    $this->userManager->updateUser($previousUser);
                }

                $user->setFacebookId($response['id']);
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
			return $class === 'UserBundle\\Entity\\Member' || is_subclass_of($class, 'UserBundle\\Entity\\Member');
		}
	}
