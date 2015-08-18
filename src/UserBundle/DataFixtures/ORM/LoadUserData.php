<?php

	namespace UserBundle\DataFixtures\ORM;

	use Doctrine\Common\DataFixtures\FixtureInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\DependencyInjection\ContainerAwareInterface;
	use Symfony\Component\DependencyInjection\ContainerInterface;

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

			$userManager = $this->container->get('fos_user.user_manager');

			$user = $userManager->createUser();
			$user->setUsername('admin');
//			$user->setFirstname('admin');
//			$user->setLastname('admin');
			$user->setEmail('contact@uneak.fr');
			$user->setPlainPassword('admin');
			$user->setEnabled(true);
			$user->setRoles(array('ROLE_ADMIN'));

			$userManager->updateUser($user, true);


		}

	}
