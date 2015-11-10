<?php

	namespace GroupFieldBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Symfony\Component\Validator\Constraints\NotNull;
	use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * GroupField
	 *
	 * @ORM\Table(name="Field")
	 * @ORM\Entity(repositoryClass="GroupFieldBundle\Entity\GroupFieldRepository")
	 *
	 * @Uploadable
	 *
	 */
	class GroupField {

		use TimestampableEntity;

		/**
		 * @var integer
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


		/**
		 * @ORM\ManyToOne(targetEntity="\ProspectGroupBundle\Entity\ProspectGroup", cascade={"persist"})
		 * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $group;

		/**
		 * @ORM\Column(name="enabled", type="boolean")
		 */
		protected $enabled = false;



		public function __toString() {
			return ''.$this->getId();
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
		public function getGroup() {
			return $this->group;
		}

		/**
		 * @param mixed $group
		 */
		public function setGroup($group) {
			$this->group = $group;
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
