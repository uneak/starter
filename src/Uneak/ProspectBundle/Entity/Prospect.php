<?php

    namespace Uneak\ProspectBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
	use Gedmo\Timestampable\Traits\TimestampableEntity;
	use Gedmo\Mapping\Annotation as Gedmo;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Uneak\FieldDataBundle\Entity\FieldData;
    use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


	/**
	 * Prospect
	 *
	 * @ORM\Table(name="Prospect")
	 * @ORM\Entity(repositoryClass="Uneak\ProspectBundle\Entity\ProspectRepository")
	 *
	 * @Uploadable
	 *
	 */
	class Prospect implements UserInterface {

		use TimestampableEntity;

		/**
		 *
		 * @ORM\Column(name="id", type="integer")
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $id;


        /**
         * @var string
         *
         * @ORM\Column(name="code", type="string", length=255, nullable=true)
         */
        protected $code;

        /**
         * @var boolean
         * @ORM\Column(name="enabled", type="boolean")
         */
        protected $enabled = false;

		/**
		 *
		 * @ORM\Column(name="source", type="string", length=64, nullable=true)
		 */
		protected $source;



        /**
         * @ORM\OneToMany(targetEntity="\Uneak\FieldDataBundle\Entity\FieldData", mappedBy="prospect", cascade={"persist", "remove"})
         */
        protected $fieldDatas;



        /**
         * The salt to use for hashing
         *
         * @var string
         * @ORM\Column(name="salt", type="string", length=255)
         */
        protected $salt;

        /**
         * Encrypted password.
         *
         * @var string
         * @ORM\Column(name="password", type="string", length=64, nullable=true)
         *
         */
        protected $password;

        /**
         * Plain password.
         *
         * @var string
         */
        protected $plainPassword;



        /**
         * Constructor
         */
        public function __construct() {
            $this->fieldDatas = new ArrayCollection();
            $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        }


        public function __toString() {
            return $this->getCode();
        }





        /**
         * Add fieldData
         *
         * @param FieldData $fieldData
         *
         * @return Prospect
         */
        public function addFieldData(FieldData $fieldData) {
            $fieldData->setProspect($this);
            $this->fieldDatas[] = $fieldData;
            return $this;
        }

        /**
         * Remove fieldData
         *
         * @param FieldData $fieldData
         */
        public function removeFieldData(FieldData $fieldData) {
            $fieldData->setProspect(null);
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
         * @return Prospect
         */
        public function setFieldDatas(ArrayCollection $fieldDatas) {
            /** @var $fieldData FieldData */
            foreach ($fieldDatas as $fieldData) {
                $fieldData->setProspect($this);
            }
            $this->fieldDatas = $fieldDatas;
            return $this;
        }








        public function hasField($property) {
            /** @var $fieldData FieldData */
            foreach ($this->fieldDatas as $fieldData) {
                if ($fieldData->getField()->getSlug() == $property) {
                    return true;
                }
            }
            return false;
        }


        public function getField($property) {
            /** @var $fieldData FieldData */
            foreach ($this->fieldDatas as $fieldData) {
                if ($fieldData->getField()->getSlug() == $property) {
                    return $fieldData->getValue();
                }
            }

            throw new \InvalidArgumentException("Le champs ".$property." n'existe pas pour ce prospect");
        }

        public function setField($property, $value) {
            /** @var $fieldData FieldData */
            foreach ($this->fieldDatas as $fieldData) {
                if ($fieldData->getField()->getSlug() == $property) {
                    $fieldData->setValue($value);
                    return $this;
                }
            }

            throw new \InvalidArgumentException("Le champs ".$property." n'existe pas pour ce prospect");
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
         * @return string
         */
        public function getCode() {
            return $this->code;
        }

        /**
         * @param string $code
         */
        public function setCode($code) {
            $this->code = $code;
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




        /** @see \Serializable::serialize() */
        public function serialize()
        {
            return serialize(array(
                $this->id,
                $this->code,
                $this->password,
                $this->salt,
                $this->enabled,
            ));
        }

        /** @see \Serializable::unserialize() */
        public function unserialize($serialized)
        {
            list (
                $this->id,
                $this->code,
                $this->password,
                $this->salt,
                $this->enabled,
                ) = unserialize($serialized);
        }



        /**
         * Returns the roles granted to the user.
         *
         * <code>
         * public function getRoles()
         * {
         *     return array('ROLE_USER');
         * }
         * </code>
         *
         * Alternatively, the roles might be stored on a ``roles`` property,
         * and populated in any number of different ways when the user object
         * is created.
         *
         * @return Role[] The user roles
         */
        public function getRoles() {
            return array('ROLE_PROSPECT');
        }

        /**
         * Returns the password used to authenticate the user.
         *
         * This should be the encoded password. On authentication, a plain-text
         * password will be salted, encoded, and then compared to this value.
         *
         * @return string The password
         */
        public function getPassword() {
            return $this->plainPassword;
        }


        public function setPassword($password)
        {
            $this->password = $password;
            return $this;
        }


        public function getPlainPassword()
        {
            return $this->plainPassword;
        }


        public function setPlainPassword($password)
        {
            $this->plainPassword = $password;
            return $this;
        }


        /**
         * Returns the salt that was originally used to encode the password.
         *
         * This can return null if the password was not encoded using a salt.
         *
         * @return string|null The salt
         */
        public function getSalt() {
            return $this->salt;
        }

        /**
         * Returns the username used to authenticate the user.
         *
         * @return string The username
         */
        public function getUsername() {
            return $this->code;
        }

        /**
         * Removes sensitive data from the user.
         *
         * This is important if, at any given point, sensitive information like
         * the plain-text password is stored on this object.
         */
        public function eraseCredentials() {
            $this->plainPassword = null;
        }



	}
