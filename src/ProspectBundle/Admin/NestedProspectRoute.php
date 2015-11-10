<?php

	namespace ProspectBundle\Admin;

	use Doctrine\ORM\EntityManager;
	use Uneak\RoutesManagerBundle\Routes\NestedEntityRoute;

    class NestedProspectRoute extends NestedEntityRoute {

		public function findEntity(EntityManager $em, $entityClass, $parameter) {
			$entityRepository = $em->getRepository($entityClass);
			return $entityRepository->findOneBySlug($parameter);
		}

	}
