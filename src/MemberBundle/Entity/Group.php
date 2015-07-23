<?php

	namespace MemberBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\Group as BaseGroup;

	/**
	 * User
	 *
	 * @ORM\Table(name="Group")
	 * @ORM\Entity(repositoryClass="MemberBundle\Entity\GroupRepository")
	 *
	 */
	class Group extends BaseGroup {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;

	}