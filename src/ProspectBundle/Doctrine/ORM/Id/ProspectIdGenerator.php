<?php

	namespace ProspectBundle\Doctrine\ORM\Id;

	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Id\AbstractIdGenerator;

	class ProspectIdGenerator extends AbstractIdGenerator {

		public function generate(EntityManager $em, $entity) {

			// Base64 (trop long)
//			$string = $entity->getFirstName() . $entity->getLastName() . $entity->getEmail() . $entity->getPhone();
			$string = $entity->getId() . $entity->getGroup()->getId();
			$data = base64_encode($string);
			$no_of_eq = substr_count($data, "=");
			$data = str_replace("=", "", $data);
			$data = $data . $no_of_eq;
			$data = str_replace(array('+', '/'), array('-', '_'), $data);

			// SOLUTION 2
//			$string = $entity->getPhone();
//			$data = bin2hex($string);

			return $data;
		}
	}
