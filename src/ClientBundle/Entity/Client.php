<?php

	namespace ClientBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
	use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Symfony\Component\HttpFoundation\File\File;
	use Gedmo\Mapping\Annotation as Gedmo;
	use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * Client
	 *
	 * @ORM\Table(name="Client")
	 * @ORM\Entity(repositoryClass="ClientBundle\Entity\ClientRepository")
	 *
	 * @Uploadable
	 *
	 */
	class Client {

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
		 * @ORM\OneToMany(targetEntity="\ClientBundle\Entity\ClientUser", mappedBy="client", cascade={"persist", "remove"})
		 */
		protected $clientUsers;
		
		/**
		 * @var boolean
		 */
		protected $enabled = false;


		/**
		 * Constructor
		 */
		public function __construct() {
			$this->clientUsers = new \Doctrine\Common\Collections\ArrayCollection();
		}




		/**
		 * Add clientUsers
		 *
		 * @param \ClientBundle\Entity\ClientUser $clientUser
		 *
		 * @return Client
		 */
		public function addClientUser(\ClientBundle\Entity\ClientUser $clientUser) {
			$clientUser->setClient($this);
			$this->clientUsers[] = $clientUser;
			return $this;
		}

		/**
		 * Remove clientUsers
		 *
		 * @param \ClientBundle\Entity\ClientUser $clientUser
		 */
		public function removeClientUser(\ClientBundle\Entity\ClientUser $clientUser) {
			$clientUser->setClient(null);
			$this->clientUsers->removeElement($clientUser);
		}

		/**
		 * Get clientUsers
		 *
		 * @return \Doctrine\Common\Collections\Collection
		 */
		public function getClientUsers() {
			return $this->clientUsers;
		}


		/**
		 * Set clientUsers
		 * @param \Doctrine\Common\Collections\ArrayCollection
		 *
		 * @return Client
		 */
		public function setClientUsers(\Doctrine\Common\Collections\ArrayCollection $clientUsers) {
			foreach ($clientUsers as $clientUser) {
				$clientUser->setClient($this);
			}
			$this->$clientUsers = $clientUsers;
			return $this;
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
