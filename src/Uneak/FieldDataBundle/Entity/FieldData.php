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
		 * @var string
		 * @ORM\Column(name="value", type="text", nullable=true)
		 */
		protected $value;


		public function __construct(Prospect $prospect = null, Field $field = null, $type = null, $value = null) {
			if ($type && in_array($type, self::TYPE())) {
				throw new \InvalidArgumentException("Type de donnée inconnu : ".$type);
			}
			$this->prospect = ($prospect) ? $prospect : null;
			$this->field = ($field) ? $field : null;
			$this->type = $type;
			$this->value = $value;
		}


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