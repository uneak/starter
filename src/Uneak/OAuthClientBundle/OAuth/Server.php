<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Symfony\Component\OptionsResolver\OptionsResolver;

    class Server extends Configuration implements ServerInterface {


        public function __construct(array $options = array()) {
            parent::__construct($options);
        }

        public function configureOptions(OptionsResolver $resolver) {
            $resolver->setDefined("name");
            $resolver->setDefaults(array(
                'authEndpoint'    => null,
                'tokenEndpoint'    => null,
            ));

            $resolver->setRequired(array('authEndpoint', 'tokenEndpoint'));
            $resolver->setAllowedTypes('authEndpoint', 'string');
            $resolver->setAllowedTypes('tokenEndpoint', 'string');
        }

		public function getAuthEndpoint() {
            return $this->getOption('authEndpoint');
		}

		public function getTokenEndpoint() {
            return $this->getOption('tokenEndpoint');
		}


        public function getOptions()
        {
            $this->options = array_merge($this->options, array("name" => $this->getName()));
            return parent::getOptions();
        }

        public function getName() {
            return "default";
        }

	}
