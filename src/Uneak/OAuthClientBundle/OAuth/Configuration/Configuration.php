<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;

    class Configuration implements ConfigurationInterface {

        protected $options;
        protected $resolver;
        protected $resolved = false;

        public function __construct(array $options = array()) {
            $this->options = $options;
            $this->resolver = new OptionsResolver();
            $this->configureOptions($this->resolver);
        }

        public function configureOptions(OptionsResolver $resolver) {
            $resolver->setDefaults(array(
                'service'   => 'default',
                'service_type'  => 'oauth',
            ));
            $resolver->setRequired("service");
            $resolver->setRequired("service_type");

            $resolver->setAllowedTypes('service', 'string');
            $resolver->setAllowedTypes('service_type', 'string');
        }

        public function setOption($key, $value) {
            $this->options[$key] = $value;
            $this->resolved = false;
        }

        public function getOption($key) {
            if (!$this->resolved) {
                $this->resolve();
            }
            return $this->options[$key];
        }

        public function getOptions()
        {
            if (!$this->resolved) {
                $this->resolve();
            }
            return $this->options;
        }

        public function setOptions(array $options)
        {
            $this->options = $options;
            $this->resolved = false;
        }

        protected function resolve() {
            $this->options = $this->resolver->resolve($this->options);
            $this->resolved = true;
        }

        public function getService() {
            return $this->getOption('service');
        }

        public function getServiceType() {
            return $this->getOption('service_type');
        }
	}
