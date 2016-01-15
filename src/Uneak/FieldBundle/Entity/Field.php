<?php

	namespace Uneak\FieldBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Event\LifecycleEventArgs;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\ORM\Query\Expr\Join;
    use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;
    use Symfony\Component\Validator\Constraints\NotNull;
    use Uneak\FieldDataBundle\Entity\FieldData;
    use Uneak\ProspectBundle\Entity\Prospect;


    /**
	 * Field
	 *
	 * @ORM\Table(name="Field")
	 * @ORM\Entity(repositoryClass="Uneak\FieldBundle\Entity\FieldRepository")
     * @ORM\HasLifecycleCallbacks()
	 *
	 */
	class Field {

        use TimestampableEntity;
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
         * @ORM\ManyToOne(targetEntity="\Uneak\FieldGroupBundle\Entity\FieldGroup", cascade={"persist"})
         * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
         * @NotNull()
         */
        protected $group;

        /**
         * @ORM\Column(name="type", type="string", length=128, nullable=false)
         * @NotNull()
         */
        protected $type;

        /**
         * @ORM\Column(name="sort", type="integer", nullable=false)
         */
        protected $sort = 0;

        /**
         * @ORM\Column(name="enabled", type="boolean")
         */
        protected $enabled = false;


        /**
         * @ORM\OneToMany(targetEntity="\Uneak\FieldDataBundle\Entity\FieldData", mappedBy="field", cascade={"persist", "remove"})
         */
        protected $fieldDatas;


        /**
         * @ORM\Column(name="field_type", type="string", length=128, nullable=true)
         */
        protected $fieldType;

        /**
         * @ORM\Column(name="options", type="json_array", nullable=true)
         */
        protected $options;


        /**
         * Constructor
         */
        public function __construct() {
            $this->fieldDatas = new ArrayCollection();
        }


        public function __toString() {
            return $this->getLabel();
        }


        /**
         * @ORM\PostUpdate()
         */
        public function updateCache(LifecycleEventArgs $eventArgs)
        {
            $em = $eventArgs->getEntityManager();
            $qb = $em->createQueryBuilder();
            $qb->select('prospect');
            $qb->from('UneakProspectBundle:Prospect', 'prospect');
            $qb->innerJoin('prospect.fieldDatas', 'fieldData');
            $qb->innerJoin('fieldData.field', 'field');

            $qb->where($qb->expr()->eq('field.id', ':field'));
            $qb->setParameter("field", $this->id);

            $prospects = $qb->getQuery()->getResult();

            /** @var $prospect Prospect */
            foreach ($prospects as $prospect) {
                $prospect->updateCache();
            }
            $em->flush();
        }



        /**
         * @return mixed
         */
        public function getOptions() {
            return $this->options;
        }

        /**
         * @param mixed $options
         */
        public function setOptions($options) {
            $this->options = $options;
        }



        /**
         * Add fieldData
         *
         * @param FieldData $fieldData
         *
         * @return Field
         */
        public function addFieldData(FieldData $fieldData) {
            $fieldData->setField($this);
            $this->fieldDatas[] = $fieldData;
            return $this;
        }

        /**
         * Remove fieldData
         *
         * @param FieldData $fieldData
         */
        public function removeFieldData(FieldData $fieldData) {
            $fieldData->setField(null);
            $this->fieldDatas->removeElement($fieldData);
        }

        /**
         * Get fieldDatas
         *
         * @return \Doctrine\Common\Collections\Collection
         */
        public function getFieldDatas() {
            return $this->fieldDatas;
        }


        /**
         * Set fieldDatas
         * @param ArrayCollection
         *
         * @return Field
         */
        public function setFieldDatas(ArrayCollection $fieldDatas) {
            /** @var $fieldData FieldData */
            foreach ($fieldDatas as $fieldData) {
                $fieldData->setField($this);
            }
            $this->fieldDatas = $fieldDatas;
            return $this;
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
        public function getFieldType() {
            return $this->fieldType;
        }

        /**
         * @param mixed $fieldType
         */
        public function setFieldType($fieldType) {
            $this->fieldType = $fieldType;
        }


        /**
         * @return mixed
         */
        public function getType() {
            return $this->type;
        }

        /**
         * @param mixed $type
         */
        public function setType($type) {
            $this->type = $type;
        }

        /**
         * @return mixed
         */
        public function getSort() {
            return $this->sort;
        }

        /**
         * @param mixed $sort
         */
        public function setSort($sort) {
            $this->sort = $sort;
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
