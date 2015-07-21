<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
    use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


	/**
	 * User
	 *
	 * @ORM\Table(name="User_User")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserUserRepository")
     * @UniqueEntity(fields = "username", targetClass = "UserBundle\Entity\User", message="fos_user.username.already_used")
     * @UniqueEntity(fields = "email", targetClass = "UserBundle\Entity\User", message="fos_user.email.already_used")
	 *
	 */
	class UserUser extends User {

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;

        /**
         * @ORM\Column(name="facebook_id", type="string", length=64)
         */
        protected $facebookId;

        /**
         * @ORM\Column(name="google_id", type="string", length=64)
         */
        protected $googleId;

        /**
         * @ORM\Column(name="twitter_id", type="string", length=64)
         */
        protected $twitterId;

        /**
         * @ORM\Column(name="firstName", type="string", length=64)
         */
        protected $firstName;

        /**
         * @ORM\Column(name="lastName", type="string", length=64)
         */
        protected $lastName;

		public function __construct() {
			parent::__construct();
			// your own logic
		}


        /**
         * @return mixed
         */
        public function getTwitterId() {
            return $this->twitterId;
        }

        /**
         * @param mixed $twitterId
         */
        public function setTwitterId($twitterId) {
            $this->twitterId = $twitterId;
        }

        /**
         * @return mixed
         */
        public function getGoogleId() {
            return $this->googleId;
        }

        /**
         * @param mixed $googleId
         */
        public function setGoogleId($googleId) {
            $this->googleId = $googleId;
        }

        /**
         * @return mixed
         */
        public function getFacebookId() {
            return $this->facebookId;
        }

        /**
         * @param mixed $facebookId
         */
        public function setFacebookId($facebookId) {
            $this->facebookId = $facebookId;
        }


        /**
         * @return mixed
         */
        public function getFirstName() {
            return $this->firstName;
        }

        /**
         * @param mixed $firstName
         */
        public function setFirstName($firstName) {
            $this->firstName = $firstName;
        }

        /**
         * @return mixed
         */
        public function getLastName() {
            return $this->lastName;
        }

        /**
         * @param mixed $lastName
         */
        public function setLastName($lastName) {
            $this->lastName = $lastName;
        }

        public function __toString() {
            return $this->firstName . " " . $this->lastName;
        }
	}
