<?php

	namespace Uneak\OAuthClientBundle\OAuth;

    use Symfony\Component\DependencyInjection\ContainerAware;

    class ServicesManager extends ContainerAware {

        protected $services = array();

        public function addService($id, $service) {
            $this->services[$id] = $service;
            return $this;
        }

        public function setServices(array $services) {
            $this->services = $services;
        }

        public function getServices() {
            return $this->services;
        }

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

        public function hasService($id) {
            return isset($this->services[$id]);
        }

        public function removeService($id) {
            unset($this->services[$id]);
            return $this;
        }

    }
