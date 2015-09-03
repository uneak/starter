<?php

	namespace UserBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use FOS\UserBundle\Model\User as BaseUser;
	use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Vich\UploaderBundle\Mapping\Annotation as Vich;
	use Gedmo\Mapping\Annotation as Gedmo;


	/**
	 * User
	 *
	 * @ORM\Table(name="AdminUser")
	 * @UniqueEntity("username")
	 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
	 * @Vich\Uploadable
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
		 * @var datetime $createdAt
		 *
		 * @Gedmo\Timestampable(on="create")
		 * @ORM\Column(name="created_at", type="datetime")
		 */
		protected $createdAt;

		/**
		 * @var datetime $updatedAt
		 *
		 * @Gedmo\Timestampable(on="update")
		 * @ORM\Column(name="updated_at", type="datetime")
		 */
		protected $updatedAt;

		/**
		 * @ORM\Column(name="firstName", type="string", length=64)
		 */
		protected $firstName;

		/**
		 * @ORM\Column(name="lastName", type="string", length=64)
		 */
		protected $lastName;

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
			// your own logic
		}

		public function __toString() {
			return $this->firstName . " " . $this->lastName;
		}


		/**
		 * Set createdAt
		 *
		 * @param \DateTime $createdAt
		 *
		 * @return instance
		 */
		public function setCreatedAt($createdAt) {
			$this->createdAt = $createdAt;

			return $this;
		}

		/**
		 * Get createdAt
		 *
		 * @return \DateTime
		 */
		public function getCreatedAt() {
			return $this->createdAt;
		}

		/**
		 * Set updatedAt
		 *
		 * @param \DateTime $updatedAt
		 *
		 * @return User
		 */
		public function setUpdatedAt($updatedAt) {
			$this->updatedAt = $updatedAt;
			return $this;
		}

		/**
		 * Get updatedAt
		 *
		 * @return \DateTime
		 */
		public function getUpdatedAt() {
			return $this->updatedAt;
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

	}
