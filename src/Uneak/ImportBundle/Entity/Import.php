<?php

	namespace Uneak\ImportBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;
    use Uneak\FieldBundle\Entity\Field;
	use Uneak\FieldGroupBundle\Entity\FieldGroup;
	use Uneak\ProspectBundle\Entity\Prospect;


    /**
	 * Import
	 *
	 * @ORM\Table(name="Import")
	 * @ORM\Entity(repositoryClass="Uneak\ImportBundle\Entity\ImportRepository")
	 *
	 *
	 */
	class Import {

		const STATUS_INIT = "STATUS_INIT";
		const STATUS_READY = "STATUS_READY";
		const STATUS_PROGRESS = "STATUS_PROGRESS";
		const STATUS_COMPLETE = "STATUS_COMPLETE";
		const STATUS_ERROR = "STATUS_ERROR";

		static function STATUS() {
			return array(
				self::STATUS_INIT => "Initialisation",
				self::STATUS_READY => "Pret",
				self::STATUS_PROGRESS => "Progression",
				self::STATUS_COMPLETE => "Termine",
				self::STATUS_ERROR => "Error",
			);
		}


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
		 * @var integer
		 *
		 * @ORM\Column(name="process", type="integer", nullable=true)
		 */
		protected $process;


		/**
		 * @ORM\ManyToOne(targetEntity="\Uneak\FieldGroupBundle\Entity\FieldGroup", inversedBy="imports", cascade={"persist"})
		 * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
		 * */
		protected $group;

		/**
		 * @var array
		 * @ORM\Column(name="fields", type="json_array", nullable=true)
		 */
		protected $fields;

		/**
		 * @var array
		 * @ORM\Column(name="datas", type="json_array", nullable=true)
		 */
		protected $datas;

		/**
		 * @var string
		 * @ORM\Column(name="status", type="string", length=128, nullable=false)
		 */
		protected $status;

		/**
		 * @var integer
		 * @ORM\Column(name="current", type="integer")
		 */
		protected $current = 0;

		/**
		 * @var integer
		 * @ORM\Column(name="total", type="integer")
		 */
		protected $total = 0;


		public function __construct(FieldGroup $group, array $fields, array $datas) {
			$this->setGroup($group);
			$this->setFields($fields);
			$this->setDatas($datas);
			$this->status = self::STATUS_INIT;
		}


		public function __toString() {
			return 'Import '.$this->getId();
		}

		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
		}


		/**
		 * @return int
		 */
		public function getProcess() {
			return $this->process;
		}


		/**
		 * @param int $process
		 */
		public function setProcess($process) {
			$this->process = $process;
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
		 * @return array
		 */
		public function getFields() {
			return $this->fields;
		}

		/**
		 * @param array $fields
		 */
		public function setFields($fields) {
			$this->fields = $fields;
		}

		/**
		 * @return array
		 */
		public function getDatas() {
			return $this->datas;
		}

		/**
		 * @param array $datas
		 */
		public function setDatas($datas) {
			$this->datas = $datas;
			$this->total = count($datas);
		}

		/**
		 * @return string
		 */
		public function getStatus() {
			return $this->status;
		}

		/**
		 * @param string $status
		 */
		public function setStatus($status) {
			$this->status = $status;
		}

		/**
		 * @return int
		 */
		public function getCurrent() {
			return $this->current;
		}

		/**
		 * @param int $current
		 */
		public function setCurrent($current) {
			$this->current = $current;
		}

		/**
		 * @return int
		 */
		public function getTotal() {
			return $this->total;
		}


	}