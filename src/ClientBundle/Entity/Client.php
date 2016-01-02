<?php

	namespace ClientBundle\Entity;

	use AppBundle\Traits\DesignationableEntity;
	use AppBundle\VichUploader\Traits\ImageableEntity;
    use CampaignBundle\Entity\Campaign;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;
    use Uneak\FieldGroupBundle\Entity\FieldGroup;
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
         * @ORM\OneToMany(targetEntity="\Uneak\FieldGroupBundle\Entity\FieldGroup", mappedBy="client", cascade={"persist", "remove"})
         */
        protected $groups;

        /**
         * @ORM\OneToMany(targetEntity="\CampaignBundle\Entity\Campaign", mappedBy="client", cascade={"persist", "remove"})
         */
        protected $campaigns;

		/**
		 * @var boolean
		 */
		protected $enabled = false;


		/**
		 * Constructor
		 */
		public function __construct() {
			$this->clientUsers = new ArrayCollection();
			$this->groups = new ArrayCollection();
			$this->campaigns = new ArrayCollection();
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
		 * @return ArrayCollection
		 */
		public function getClientUsers() {
			return $this->clientUsers;
		}

		/**
		 * Set clientUsers
		 * @param ArrayCollection
		 *
		 * @return Client
		 */
		public function setClientUsers(ArrayCollection $clientUsers) {
			foreach ($clientUsers as $clientUser) {
				$clientUser->setClient($this);
			}
			$this->$clientUsers = $clientUsers;
			return $this;
		}







        /**
         * Add groups
         *
         * @param FieldGroup $group
         *
         * @return Client
         */
        public function addGroup(FieldGroup $group) {
            $group->setClient($this);
            $this->groups[] = $group;
            return $this;
        }

        /**
         * Remove groups
         *
         * @param FieldGroup $group
         */
        public function removeGroup(FieldGroup $group) {
            $group->setClient(null);
            $this->groups->removeElement($group);
        }

        /**
         * Get groups
         *
         * @return ArrayCollection
         */
        public function getGroups() {
            return $this->groups;
        }

        /**
         * Set groups
         * @param ArrayCollection
         *
         * @return Client
         */
        public function setGroups(ArrayCollection $groups) {
            foreach ($groups as $group) {
                $group->setClient($this);
            }
            $this->$groups = $groups;
            return $this;
        }







        /**
         * Add campaigns
         *
         * @param Campaign $campaign
         *
         * @return Client
         */
        public function addCampaign(Campaign $campaign) {
            $campaign->setClient($this);
            $this->campaigns[] = $campaign;
            return $this;
        }

        /**
         * Remove campaigns
         *
         * @param Campaign $campaign
         */
        public function removeCampaign(Campaign $campaign) {
            $campaign->setClient(null);
            $this->campaigns->removeElement($campaign);
        }

        /**
         * Get campaigns
         *
         * @return ArrayCollection
         */
        public function getCampaigns() {
            return $this->campaigns;
        }

        /**
         * Set campaigns
         * @param ArrayCollection
         *
         * @return Client
         */
        public function setCampaigns(ArrayCollection $campaigns) {
            foreach ($campaigns as $campaign) {
                $campaign->setClient($this);
            }
            $this->$campaigns = $campaigns;
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
