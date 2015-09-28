<?php

	namespace Uneak\OAuthClientBundle\OAuth;

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
        }

        public function getOption($key) {
            if (!$this->resolved) {
                $this->_resolve();
            }
            return $this->options[$key];
        }

        public function getOptions()
        {
            if (!$this->resolved) {
                $this->_resolve();
            }
            return $this->options;
        }

        public function setOptions(array $options)
        {
            $this->options = $options;
            $this->resolved = false;
        }

        private function _resolve() {
            $this->options = $this->resolver->resolve($this->options);
            $this->resolved = true;
        }


	}
