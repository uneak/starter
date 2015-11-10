<?php

	namespace ProspectBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Symfony\Component\Validator\Constraints\NotNull;
	use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * Prospect
	 *
	 * @ORM\Table(name="Prospect")
	 * @ORM\Entity(repositoryClass="ProspectBundle\Entity\ProspectRepository")
	 *
	 * @Uploadable
	 *
	 */
	class Prospect {

		use TimestampableEntity;

		/**
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


		/**
		 *
		 * @ORM\Column(name="slug", type="string", length=64, nullable=true)
		 */
		protected $slug;


		/**
		 *
		 * @ORM\Column(name="source", type="string", length=64, nullable=true)
		 */
		protected $source;

		/**
		 * @ORM\ManyToOne(targetEntity="\ProspectGroupBundle\Entity\ProspectGroup", cascade={"persist"})
		 * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $group;


		public function __toString() {
			return ''.$this->getId();
		}

		/**
		 * @return mixed
		 */
		public function getSource() {
			return $this->source;
		}

		/**
		 * @param mixed $source
		 */
		public function setSource($source) {
			$this->source = $source;
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
		public function getSlug() {
			return $this->slug;
		}

		/**
		 * @param mixed $slug
		 */
		public function setSlug($slug) {
			$this->slug = $slug;
		}


		/**
		 * @return mixed
		 */
		public function getGroup() {
			return $this->group;
		}

		/***
		 * @param mixed $group
		 */
		public function setGroup($group) {
			$this->group = $group;
		}


	}
