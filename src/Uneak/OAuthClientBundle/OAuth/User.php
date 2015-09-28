<?php

	namespace Uneak\OAuthClientBundle\OAuth;

    use Symfony\Component\PropertyAccess\PropertyAccess;

    class User {

        protected $firstName;
        protected $lastName;
        protected $userName;
        protected $link;
        protected $email;
        protected $picture;
        protected $id;

        public function __construct($data, array $association) {
            $accessor = PropertyAccess::createPropertyAccessor();
            foreach ($association as $internal => $external) {
                $externalPath = explode('.', $external);
                $value = $data;
                for($i=0; $i < count($externalPath); $i++) {
                    $value = $value[$externalPath[$i]];
                }
                $accessor->setValue($this, $internal, $value);
            }
        }



        /**
         * @return mixed
         */
        public function getFirstName()
        {
            return $this->firstName;
        }

        /**
         * @param mixed $firstName
         */
        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;
        }

        /**
         * @return mixed
         */
        public function getLastName()
        {
            return $this->lastName;
        }

        /**
         * @param mixed $lastName
         */
        public function setLastName($lastName)
        {
            $this->lastName = $lastName;
        }

        /**
         * @return mixed
         */
        public function getUserName()
        {
            return $this->userName;
        }

        /**
         * @param mixed $userName
         */
        public function setUserName($userName)
        {
            $this->userName = $userName;
        }

        /**
         * @return mixed
         */
        public function getLink()
        {
            return $this->link;
        }

        /**
         * @param mixed $link
         */
        public function setLink($link)
        {
            $this->link = $link;
        }

        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @return mixed
         */
        public function getPicture()
        {
            return $this->picture;
        }

        /**
         * @param mixed $picture
         */
        public function setPicture($picture)
        {
            $this->picture = $picture;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }


	}
