<?php

	namespace MemberBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;


	/**
	 * User
	 *
	 * @ORM\Table(name="User")
	 * @ORM\Entity(repositoryClass="MemberBundle\Entity\UserRepository")
	 *
	 */
	class User extends BaseUser {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


		/**
		 * @ORM\ManyToMany(targetEntity="MemberBundle\Entity\Group")
		 * @ORM\JoinTable(name="UserGroup",
		 *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
		 *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
		 * )
		 */
		protected $groups;



		public function __construct() {
			parent::__construct();
			// your own logic
		}

	}
