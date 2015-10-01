<?php

	namespace Uneak\OAuthClientBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
    use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;


	/**
	 * User
	 *
	 * @ORM\Table(name="OAuthUser")
	 * @ORM\Entity(repositoryClass="Uneak\OAuthClientBundle\Entity\OAuthUserRepository")
	 *
	 */
	class OAuthUser {


		/**
		 * @ORM\Column(name="service", type="string", length=64, nullable=true)
		 * @ORM\Id
		 */
		protected $service;

		/**
		 * @ORM\Column(name="id", type="string", length=255)
		 * @ORM\Id
		 */
		protected $id;

        /**
         * Hook timestampable behavior
         * updates createdAt, updatedAt fields
         */
        use TimestampableEntity;

		/**
		 * @ORM\Column(name="data", type="json_array", nullable=true)
		 */
		protected $data;

		/**
		 * @ORM\Column(name="access_token", type="json_array", nullable=true)
		 */
		protected $token;


		/**
		 * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
		 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
		 */
		protected $user;



		/**
		 * Set user
		 *
		 * @param \UserBundle\Entity\User $user
		 *
		 * @return OAuthUser
		 */
		public function setUser(\UserBundle\Entity\User $user = null) {
			$this->user = $user;
			return $this;
		}

		/**
		 * Get user
		 *
		 * @return \UserBundle\Entity\User
		 */
		public function getUser() {
			return $this->user;
		}
		
		

		public function __toString() {
			return $this->service . ":" . $this->id;
		}

		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @param int $id
		 */
		public function setId($id) {
			$this->id = $id;
		}

		/**
		 * @return mixed
		 */
		public function getData() {
			return $this->data;
		}

		/**
		 * @param mixed $data
		 */
		public function setData($data) {
			$this->data = $data;
		}

		/**
		 * @return mixed
		 */
		public function getToken() {
			return $this->token;
		}

		/**
		 * @param mixed $token
		 */
		public function setToken($token) {
			$this->token = $token;
		}

		/**
		 * @return mixed
		 */
		public function getService() {
			return $this->service;
		}

		/**
		 * @param mixed $service
		 */
		public function setService($service) {
			$this->service = $service;
		}





	}
