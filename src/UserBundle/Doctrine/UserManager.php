<?php

	/*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace UserBundle\Doctrine;

	use FOS\UserBundle\Doctrine\UserManager as FOSUserManager;

	class UserManager extends FOSUserManager {

		public function findOAuthUser($service, $id) {
			return $this->repository->findOAuthUser($service, $id);
		}

	}
