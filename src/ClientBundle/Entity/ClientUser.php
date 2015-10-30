<?php

	namespace ClientBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints\NotNull;


	/**
	 * ClientUser
	 *
	 * @ORM\Table(name="ClientUser")
	 * @ORM\Entity(repositoryClass="ClientBundle\Entity\ClientUserRepository")
	 *
	 *
	 */
	class ClientUser {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


		/**
		 * @ORM\ManyToOne(targetEntity="\ClientBundle\Entity\Client", cascade={"persist"})
		 * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $client;

		/**
		 * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", cascade={"persist"})
		 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $user;

		/**
		 * @ORM\ManyToOne(targetEntity="\ClientBundle\Entity\ClientUserRole", cascade={"persist"})
		 * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $role;

		/**
		 * @ORM\Column(name="confirm", type="boolean")
		 */
		protected $confirm = false;


		/**
		 * @ORM\Column(name="enabled", type="boolean")
		 */
		protected $enabled = false;


		public function __toString() {
			return $this->getLabel();
		}


		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @return mixed
		 */
		public function getClient() {
			return $this->client;
		}

		/**
		 * @param mixed $client
		 */
		public function setClient($client) {
			$this->client = $client;
		}

		/**
		 * @return mixed
		 */
		public function getUser() {
			return $this->user;
		}

		/**
		 * @param mixed $user
		 */
		public function setUser($user) {
			$this->user = $user;
		}

		/**
		 * @return mixed
		 */
		public function getRole() {
			return $this->role;
		}

		/**
		 * @param mixed $role
		 */
		public function setRole($role) {
			$this->role = $role;
		}

		/**
		 * @return boolean
		 */
		public function isConfirm() {
			return $this->confirm;
		}

		/**
		 * @param boolean $confirm
		 */
		public function setConfirm($confirm) {
			$this->confirm = $confirm;
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
