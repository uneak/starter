<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;


    /**
     * user
     *
     * @ORM\Entity
     * @ORM\Table(name="User")
     * @ORM\InheritanceType("JOINED")
     * @ORM\DiscriminatorColumn(name="type", type="string")
     * @ORM\DiscriminatorMap({"user_admin" = "UserAdmin", "user_user" = "UserUser"})
     *
     */
    abstract class User extends BaseUser {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


	}
