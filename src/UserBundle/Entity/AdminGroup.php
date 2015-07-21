<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\Group as BaseGroup;

	/**
	 * User
	 *
	 * @ORM\Table(name="Admin_Group")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\AdminGroupRepository")
	 *
	 */
	class AdminGroup extends BaseGroup {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;

	}
