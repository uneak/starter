<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
    use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


	/**
	 * User
	 *
	 * @ORM\Table(name="User_Admin")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserAdminRepository")
     * @UniqueEntity(fields = "username", targetClass = "UserBundle\Entity\User", message="fos_user.username.already_used")
     * @UniqueEntity(fields = "email", targetClass = "UserBundle\Entity\User", message="fos_user.email.already_used")
	 *
	 */
	class UserAdmin extends User {

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
