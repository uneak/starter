<?php

	namespace Uneak\OAuth2Client;

	use Symfony\Component\OptionsResolver\OptionsResolver;

    class Server implements ServerInterface {

        protected $options;

        public function __construct(array $options = array()) {
            $resolver = new OptionsResolver();
            $this->configureOptions($resolver);
            $this->options = $resolver->resolve($options);
        }

        public function configureOptions(OptionsResolver $resolver) {
            $resolver->setDefaults(array(
                'authEndpoint'    => null,
                'tokenEndpoint'    => null,
                'redirectUrl'    => null,
            ));

            $resolver->setRequired(array('authEndpoint', 'tokenEndpoint'));
            $resolver->setAllowedTypes('authEndpoint', 'string');
            $resolver->setAllowedTypes('tokenEndpoint', 'string');
            $resolver->setAllowedTypes('redirectUrl', 'string');

        }

        public function getOption($key) {
            return $this->options[$key];
        }

		public function getAuthEndpoint() {
            return $this->options['authEndpoint'];
		}

		public function getTokenEndpoint() {
            return $this->options['tokenEndpoint'];
		}

		public function getRedirectUrl() {
            return $this->options['redirectUrl'];
		}


        public function serialize()
        {
            return serialize($this->options);
        }

        public function unserialize($serialized)
        {
            $this->options = unserialize($serialized);
        }


	}
