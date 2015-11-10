<?php

	namespace CampaignBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Symfony\Component\Validator\Constraints\NotNull;
	use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * Campaign
	 *
	 * @ORM\Table(name="Campaign")
	 * @ORM\Entity(repositoryClass="CampaignBundle\Entity\CampaignRepository")
	 *
	 * @Uploadable
	 *
	 */
	class Campaign {

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
		 * @ORM\Column(name="enabled", type="boolean")
		 */
		protected $enabled = false;



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
