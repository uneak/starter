<?php

	namespace Uneak\OAuthClientBundle\OAuth;

    use Symfony\Component\DependencyInjection\ContainerAware;
    use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

    class ServicesManager extends ContainerAware {

        protected $services = array();
        protected $apis = array();
        protected $users = array();

		/**
         * @param $id
         * @param $service
         *
         * @return ServicesManager
         */
        public function addService($id, $service) {
            $this->services[$id] = $service;
            return $this;
        }

		/**
         * @param $id
         * @param $api
         *
         * @return ServicesManager
         */
        public function addAPI($id, $api) {
            $this->apis[$id] = $api;
            return $this;
        }

		/**
         * @param $id
         * @param $user
         *
         * @return ServicesManager
         */
        public function addUser($id, $user) {
            $this->users[$id] = $user;
            return $this;
        }

		/**
         * @param array $services
         *
         * @return ServicesManager
         */
        public function setServices(array $services) {
            $this->services = $services;
            return $this;
        }

		/**
         * @param array $apis
         *
         * @return ServicesManager
         */
        public function setAPIs(array $apis) {
            $this->apis = $apis;
            return $this;
        }

		/**
         * @param array $users
         *
         * @return ServicesManager
         */
        public function setUsers(array $users) {
            $this->users = $users;
            return $this;
        }

		/**
         * @return array
         */
        public function getServices() {
            return $this->services;
        }

		/**
         * @return array
         */
        public function getAPIs() {
            return $this->apis;
        }

		/**
         * @return array
         */
        public function getUsers() {
            return $this->users;
        }

		/**
         * @param $id
         *
         * @return ServiceInterface
         */
        public function getService($id) {
            if (!isset($this->services[$id])) {
                // TODO: execption
                return null;
            }
            if (is_string($this->services[$id])) {
                $this->services[$id] = $this->container->get($this->services[$id]);
            }

            return $this->services[$id];
        }

		/**
         * @param AccessTokenInterface $token
         *
         * @return ServiceAPI
         */
        public function getAPI(TokenInterface $token) {
            $id = $token->getService();
            if (!isset($this->apis[$id])) {
                // TODO: execption
                return null;
            }
            if (is_string($this->apis[$id])) {
                $this->apis[$id] = $this->container->get($this->apis[$id]);
            }

            $this->apis[$id]->setAccessToken($token);
            return $this->apis[$id];
        }

		/**
         * @param AccessTokenInterface|array|string $user
         *
         * @return ServiceUserInterface
         */
        public function getUser($user) {
            if ($user instanceof TokenInterface) {
                $id = $user->getService();
            } else if (is_array($user)) {
                $id = $user['service'];
            } else {
                $id = $user;
            }

            if (!isset($this->users[$id])) {
                // TODO: execption
                return null;
            }
            if (is_string($this->users[$id])) {
                $this->users[$id] = $this->container->get($this->users[$id]);
            }

            if ($user instanceof TokenInterface) {
                $this->users[$id]->setTokenData($user);
            } else if (is_array($user)) {
                $this->users[$id]->setOptions($user);
            }

            return $this->users[$id];
        }


		/**
         * @param $id
         *
         * @return bool
         */
        public function hasService($id) {
            return isset($this->services[$id]);
        }

		/**
         * @param $id
         *
         * @return bool
         */
        public function hasAPI($id) {
            return isset($this->apis[$id]);
        }

		/**
         * @param $id
         *
         * @return bool
         */
        public function hasUser($id) {
            return isset($this->users[$id]);
        }


		/**
         * @param $id
         *
         * @return ServicesManager
         */
        public function removeService($id) {
            unset($this->services[$id]);
            return $this;
        }

		/**
         * @param $id
         *
         * @return ServicesManager
         */
        public function removeAPI($id) {
            unset($this->services[$id]);
            return $this;
        }

		/**
         * @param $id
         *
         * @return ServicesManager
         */
        public function removeUser($id) {
            unset($this->services[$id]);
            return $this;
        }

    }
