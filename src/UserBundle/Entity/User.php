<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;
    use Gedmo\Timestampable\Traits\TimestampableEntity;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
	use Symfony\Component\HttpFoundation\File\File;
    use Symfony\Component\Validator\Constraints\Email;
    use Symfony\Component\Validator\Constraints\Length;
    use Symfony\Component\Validator\Constraints\NotBlank;
    use Vich\UploaderBundle\Mapping\Annotation as Vich;
	use Gedmo\Mapping\Annotation as Gedmo;


	/**
	 * User
	 *
	 * @ORM\Table(name="AdminUser")
	 * @UniqueEntity(fields={"username", "email"})
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
	 * @Vich\Uploadable
	 *
	 */
	class User extends BaseUser {


		const STATE_PROFILE_PENDING = "STATE_PROFILE_PENDING";
		const STATE_PROFILE_ACCEPT = "STATE_PROFILE_ACCEPT";
		const STATE_PROFILE_REFUSED = "STATE_PROFILE_REFUSED";

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;

        /**
         * Hook timestampable behavior
         * updates createdAt, updatedAt fields
         */
        use TimestampableEntity;



		/**
         * @ORM\Column(name="gender", type="string", length=64, nullable=true)
         */
        protected $gender;

		/**
		 * @ORM\Column(name="firstName", type="string", length=64)
         * @Length(
         *      min = "2",
         *      max = "64",
         *      minMessage = "Votre prénom doit faire au moins {{ limit }} caractères",
         *      maxMessage = "Votre prénom ne peut pas être plus long que {{ limit }} caractères"
         * )
         * @NotBlank()
		 */
		protected $firstName;

		/**
		 * @ORM\Column(name="lastName", type="string", length=64)
         * @Length(
         *      min = "2",
         *      max = "64",
         *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
         *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
         * )
         * @NotBlank()
		 */
		protected $lastName;


        /**
         *
         * @Email(
         *     message = "'{{ value }}' n'est pas un email valide.",
         *     checkMX = false
         * )
         * @NotBlank()
         */
        protected $email;

		/**
		 * @ORM\Column(name="email_confirmed", type="boolean")
		 */
		protected $emailConfirmed = false;

		/**
		 * @var boolean
		 */
		protected $enabled = false;

		/**
		 * @ORM\Column(name="state_profile", type="string", length=64)
		 */
		protected $stateProfile = self::STATE_PROFILE_PENDING;


		/**
		 * @ORM\OneToMany(targetEntity="Uneak\OAuthClientBundle\Entity\OAuthUser", mappedBy="user", cascade={"persist", "remove"})
		 */
		protected $oAuthUsers;
		
		
        /**
         * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
         * @ORM\JoinTable(name="AdminUserGroup",
         *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
         * )
         */
        protected $groups;


		/**
		 * @var string
		 *
		 * @ORM\Column(name="image", type="string", length=255, nullable=true)
		 */
		protected $image;

		/**
		 * @var File $imageFile
		 * @Vich\UploadableField(mapping="user_image", fileNameProperty="image")
		 */
		protected $imageFile;



		public function __construct() {
			parent::__construct();
			$this->oAuthUsers = new \Doctrine\Common\Collections\ArrayCollection();
		}




		/**
		 * Add oAuthUsers
		 *
		 * @param \Uneak\OAuthClientBundle\Entity\OAuthUser $oAuthUser
		 *
		 * @return User
		 */
		public function addOAuthUser(\Uneak\OAuthClientBundle\Entity\OAuthUser $oAuthUser) {
			$oAuthUser->setAgence($this);
			$this->oAuthUsers[] = $oAuthUser;
			return $this;
		}

		/**
		 * Remove oAuthUsers
		 *
		 * @param \Uneak\OAuthClientBundle\Entity\OAuthUser $oAuthUser
		 */
		public function removeOAuthUser(\Uneak\OAuthClientBundle\Entity\OAuthUser $oAuthUser) {
			$oAuthUser->setAgence(null);
			$this->oAuthUsers->removeElement($oAuthUser);
		}

		/**
		 * Get oAuthUsers
		 *
		 * @return \Doctrine\Common\Collections\Collection
		 */
		public function getOAuthUsers() {
			return $this->oAuthUsers;
		}

		/**
		 * Set oAuthUsers
		 * @param \Doctrine\Common\Collections\ArrayCollection
		 *
		 * @return User
		 */
		public function setOAuthUsers(\Doctrine\Common\Collections\ArrayCollection $oAuthUsers) {
			foreach ($oAuthUsers as $oAuthUser) {
				$oAuthUser->setAgence($this);
			}
			$this->$oAuthUsers = $oAuthUsers;
			return $this;
		}

		
		
		
		
		public function __toString() {
			return $this->firstName . " " . $this->lastName;
		}



		public function getGender() {
            return $this->gender;
        }

        public function setGender($gender) {
            $this->gender = $gender;
            return $this;
        }



        /**
		 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
		 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
		 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
		 * must be able to accept an instance of 'File' as the bundle will inject one here
		 * during Doctrine hydration.
		 *
		 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
		 */
		public function setImageFile(File $image) {
			$this->imageFile = $image;

			if ($image) {
				// It is required that at least one field changes if you are using doctrine
				// otherwise the event listeners won't be called and the file is lost
				$this->updatedAt = new \DateTime('now');
			}
		}

		/**
		 * @return File
		 */
		public function getImageFile() {
			return $this->imageFile;
		}

		/**
		 * Set image path
		 *
		 * @param string $image
		 *
		 * @return Modele
		 */
		public function setImage($image = null) {
			$this->image = $image;

			return $this;
		}

		/**
		 * Get image path
		 *
		 * @return string $image
		 */
		public function getImage() {
			return $this->image;
		}


		public function getLastName() {
			return $this->lastName;
		}

		public function setLastName($lastName) {
			$this->lastName = $lastName;
			return $this;
		}

		public function getFirstName() {
			return $this->firstName;
		}

		public function setFirstName($firstName) {
			$this->firstName = $firstName;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getEmailConfirmed() {
			return $this->emailConfirmed;
		}

		/**
		 * @param mixed $emailConfirm
		 *
		 * @return User
		 */
		public function setEmailConfirmed($emailConfirmed) {
			$this->emailConfirmed = $emailConfirmed;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getStateProfile() {
			return $this->stateProfile;
		}

		/**
		 * @param mixed $stateProfile
		 */
		public function setStateProfile($stateProfile) {
			$this->stateProfile = $stateProfile;
		}




	}
