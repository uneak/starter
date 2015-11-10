<?php

	namespace ClientBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Gedmo\Timestampable\Traits\TimestampableEntity;


	/**
	 * ClientRole
	 *
	 * @ORM\Table(name="ClientRole")
	 * @ORM\Entity(repositoryClass="ClientBundle\Entity\ClientRoleRepository")
	 *
	 *
	 */
	class ClientRole {

		const READ = "READ";
		const UPDATE = "UPDATE";
		const DELETE = "DELETE";
		const WRITE = "WRITE";

		const CONTACT_INFO = "CONTACT_INFO";
		const EXPORT = "EXPORT";
		const EXECUTE = "EXECUTE";


		use TimestampableEntity;
		use DesignationableEntity;

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;

		/**
		 * @var array
		 * @ORM\Column(name="roles", type="json_array")
		 */
		protected $roles;

		/**
		 * @ORM\Column(name="enabled", type="boolean")
		 */
		protected $enabled = false;


		public function __toString() {
			return $this->getLabel();
		}

		/**
		 * @return array
		 */
		public function getRoles() {
			return $this->roles;
		}

		/**
		 * @param array $roles
		 */
		public function setRoles($roles) {
			$this->roles = $roles;
		}


		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}


		/**
		 * @return boolean
		 */
		public function isEnabled() {
			return $this->enabled;
		}

		/**
		 * @param boolean $enabled
		 */
		public function setEnabled($enabled) {
			$this->enabled = $enabled;
		}


	}
