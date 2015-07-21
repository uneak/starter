<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;


	/**
	 * User
	 *
	 * @ORM\Table(name="Admin_User")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\AdminUserRepository")
	 *
	 */
	class AdminUser extends BaseUser {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


		/**
		 * @ORM\ManyToMany(targetEntity="UserBundle\Entity\AdminGroup")
		 * @ORM\JoinTable(name="Admin_UserGroup",
		 *      joinColumns={@ORM\JoinColumn(name="admin_user_id", referencedColumnName="id")},
		 *      inverseJoinColumns={@ORM\JoinColumn(name="admin_group_id", referencedColumnName="id")}
		 * )
		 */
		protected $groups;



		public function __construct() {
			parent::__construct();
			// your own logic
		}

	}
