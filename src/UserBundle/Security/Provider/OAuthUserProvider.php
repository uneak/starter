<?php

	namespace UserBundle\Security\Provider;

	use Doctrine\ORM\EntityManager;
	use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
	use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
	use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Core\User\UserProviderInterface;
	use UserBundle\Entity\User;


	class OAuthUserProvider implements UserProviderInterface, AccountConnectorInterface, OAuthAwareUserProviderInterface {

		protected $em;
		protected $repository;

		public function __construct(EntityManager $em) {
			$this->em = $em;
			$this->repository = $em->getRepository("UserBundle:Member");
		}

		/**
		 * {@inheritdoc}
		 */
		public function loadUserByUsername($username) {
			$user = $this->repository->findOneBy(array('username' => $username));
			if (!$user) {
				throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
			}
			return $user;
		}

		/**
		 * {@inheritdoc}
		 */
		public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
			$resourceOwnerName = $response->getResourceOwner()->getName();

			$response = $response->getResponse();

			if ($resourceOwnerName == "facebook") {
				if (null === $user = $this->repository->findOneBy(array('facebookId' => $response['id']))) {
//					throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
					$user = new User();
					$user->setFacebookId($response['id']);
					$user->setFirstName($response['first_name']);
					$user->setLastName($response['last_name']);
					$user->setEmail($response['email']);
					$user->setUsername($response['email']);
					$this->em->persist($user);
					$this->em->flush();
				}
			}


			return $user;
		}


		/**
		 * {@inheritDoc}
		 */
		public function connect(UserInterface $user, UserResponseInterface $response) {
			ld($user);
			ldd($response);

		}


		/**
		 * {@inheritdoc}
		 */
		public function refreshUser(UserInterface $user) {
//			$accessor = PropertyAccess::createPropertyAccessor();
//			$identifier = $this->properties['identifier'];
//			if (!$this->supportsClass(get_class($user)) || !$accessor->isReadable($user, $identifier)) {
//				throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
//			}
//
//			$userId = $accessor->getValue($user, $identifier);
//			if (null === $user = $this->repository->findOneBy(array($identifier => $userId))) {
//				throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $userId));
//			}

			return $user;
		}

		/**
		 * {@inheritdoc}
		 */
		public function supportsClass($class) {
			return $class === 'UserBundle\\Entity\\Member' || is_subclass_of($class, 'UserBundle\\Entity\\Member');
		}
	}
