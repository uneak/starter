<?php

	namespace AppBundle\VichUploader\Traits;

	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\HttpFoundation\File\File;
	use Vich\UploaderBundle\Mapping\Annotation as Vich;


	trait ImageableEntity {

		/**
		 * @var string
		 *
		 * @ORM\Column(name="image", type="string", length=255, nullable=true)
		 */
		protected $image;

		/**
		 * @var File $imageFile
		 * @Vich\UploadableField(mapping="entity_image", fileNameProperty="image")
		 */
		protected $imageFile;


		abstract public function setUpdatedAt(\DateTime $updatedAt);


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
				$this->setUpdatedAt(new \DateTime('now'));
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
		 * @return $this
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
	}
