<?php

	namespace Uneak\FieldDataBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;
    use Uneak\FieldBundle\Entity\Field;
    use Uneak\ProspectBundle\Entity\Prospect;


    /**
	 * FieldData
	 *
	 * @ORM\Table(name="FieldData")
	 * @ORM\Entity(repositoryClass="Uneak\FieldDataBundle\Entity\FieldDataRepository")
	 * @ORM\InheritanceType("JOINED")
	 * @ORM\DiscriminatorColumn(name="type", type="string")
	 * @ORM\DiscriminatorMap({
	 *        "integer" = "FieldDataInteger",
	 *        "string" = "FieldDataString",
	 *        "text" = "FieldDataText",
	 *        "boolean" = "FieldDataBoolean",
	 *        "datetime" = "FieldDataDatetime",
	 *        "array" = "FieldDataArray",
	 *        "float" = "FieldDataFloat",
	 * })
	 *
	 *
	 */
	class FieldData {

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
		 * @ORM\ManyToOne(targetEntity="\Uneak\FieldBundle\Entity\Field", inversedBy="fieldDatas", cascade={"persist"})
		 * @ORM\JoinColumn(name="field_id", referencedColumnName="id")
		 * */
		protected $field;


		/**
		 * @ORM\ManyToOne(targetEntity="\Uneak\ProspectBundle\Entity\Prospect", inversedBy="fieldDatas", cascade={"persist"})
		 * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id")
		 * */
		protected $prospect;


		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @return Field
		 */
		public function getField() {
			return $this->field;
		}

		/**
		 * @param mixed $field
		 */
		public function setField($field) {
			$this->field = $field;
		}

		/**
		 * @return Prospect
		 */
		public function getProspect() {
			return $this->prospect;
		}

		/**
		 * @param mixed $prospect
		 */
		public function setProspect($prospect) {
			$this->prospect = $prospect;
		}


	}


	/**
	 * FieldDataInteger
	 *
	 * @ORM\Table(name="FieldDataInteger")
	 * @ORM\Entity
	 *
	 */
	class FieldDataInteger extends FieldData {

		/**
		 * @var integer
		 * @ORM\Column(name="value", type="integer", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return int
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param int $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataFloat
	 *
	 * @ORM\Table(name="FieldDataFloat")
	 * @ORM\Entity
	 *
	 */
	class FieldDataFloat extends FieldData {

		/**
		 * @ORM\Column(name="value", type="float", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return int
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param int $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataInteger
	 *
	 * @ORM\Table(name="FieldDataString")
	 * @ORM\Entity
	 *
	 */
	class FieldDataString extends FieldData {


		/**
		 * @var string
		 * @ORM\Column(name="value", type="string", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return string
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param string $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataText
	 *
	 * @ORM\Table(name="FieldDataText")
	 * @ORM\Entity
	 *
	 */
	class FieldDataText extends FieldData {

		/**
		 * @var string
		 * @ORM\Column(name="value", type="text", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return string
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param string $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataBoolean
	 *
	 * @ORM\Table(name="FieldDataBoolean")
	 * @ORM\Entity
	 *
	 */
	class FieldDataBoolean extends FieldData {

		/**
		 * @var boolean
		 * @ORM\Column(name="value", type="boolean", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return boolean
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param boolean $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataDatetime
	 *
	 * @ORM\Table(name="FieldDataDatetime")
	 * @ORM\Entity
	 *
	 */
	class FieldDataDatetime extends FieldData {

		/**
		 * @var datetime
		 * @ORM\Column(name="value", type="datetime", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return datetime
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param datetime $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}


	/**
	 * FieldDataArray
	 *
	 * @ORM\Table(name="FieldDataArray")
	 * @ORM\Entity
	 *
	 */
	class FieldDataArray extends FieldData {

		/**
		 * @var array
		 * @ORM\Column(name="value", type="array", nullable=true)
		 */
		protected $value;

		public function __construct(Field $field = null, $value = null) {
			if ($value) {
				$this->value = $value;
			}
			if ($field) {
				$this->field = $field;
			}
		}

		/**
		 * @return array
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * @param array $value
		 */
		public function setValue($value) {
			$this->value = $value;
		}

	}