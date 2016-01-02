<?php

	namespace Uneak\FieldGroupBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Symfony\Component\Validator\Constraints\NotNull;
    use Uneak\FieldBundle\Entity\Field;
    use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * FieldGroup
	 *
	 * @ORM\Table(name="FieldGroup")
	 * @ORM\Entity(repositoryClass="Uneak\FieldGroupBundle\Entity\FieldGroupRepository")
	 *
	 * @Uploadable
	 *
	 */
	class FieldGroup {

		use TimestampableEntity;
		use ImageableEntity;
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
		 * @ORM\ManyToOne(targetEntity="\ClientBundle\Entity\Client", cascade={"persist"})
		 * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
		 * @NotNull()
		 */
		protected $client;

        /**
         * @ORM\OneToMany(targetEntity="\Uneak\FieldBundle\Entity\Field", mappedBy="group", cascade={"persist", "remove"})
         */
        protected $fields;

		/**
		 * @ORM\Column(name="enabled", type="boolean")
		 */
		protected $enabled = false;


        /**
         * Constructor
         */
        public function __construct() {
            $this->fields = new ArrayCollection();
        }


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
         * Add fields
         *
         * @param Field $field
         *
         * @return FieldGroup
         */
        public function addField(Field $field) {
            $field->setGroup($this);
            $this->fields[] = $field;
            return $this;
        }

        /**
         * Remove fields
         *
         * @param Field $field
         */
        public function removeField(Field $field) {
            $field->setGroup(null);
            $this->fields->removeElement($field);
        }

        /**
         * Get fields
         *
         * @return ArrayCollection
         */
        public function getFields() {
            return $this->fields;
        }

        /**
         * Set fields
         * @param ArrayCollection
         *
         * @return FieldGroup
         */
        public function setFields(ArrayCollection $fields) {
            foreach ($fields as $field) {
                $field->setGroup($this);
            }
            $this->$fields = $fields;
            return $this;
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
