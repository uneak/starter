<?php

	namespace UserBundle\DataFixtures\ORM;

	use Doctrine\Common\DataFixtures\FixtureInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\DependencyInjection\ContainerAwareInterface;
	use Symfony\Component\DependencyInjection\ContainerInterface;
	use UserBundle\Entity\User;

	class LoadUserData implements FixtureInterface, ContainerAwareInterface {

		private $container;

		/**
		 * {@inheritDoc}
		 */
		public function setContainer(ContainerInterface $container = null) {
			$this->container = $container;
		}

		/**
		 * {@inheritDoc}
		 */
		public function load(ObjectManager $manager) {

			$userManager = $this->container->get('uneak.user_manager');

			$user = $userManager->createUser();
			$user->setUsername('admin');
			$user->setFirstname('Marc');
			$user->setLastname('Galoyer');
			$user->setEmail('contact@uneak.fr');
			$user->setPlainPassword('admin');
			$user->setEnabled(true);
			$user->setEmailConfirmed(true);
			$user->setStateProfile(User::STATE_PROFILE_ACCEPT);
			$user->setRoles(array('ROLE_SUPER_ADMIN'));

			$userManager->updateUser($user, true);


		}

	}
