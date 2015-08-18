<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;
	use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


	/**
	 * User
	 *
	 * @ORM\Table(name="AdminUser")
	 * @UniqueEntity("username")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
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
         * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
         * @ORM\JoinTable(name="AdminUserGroup",
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
