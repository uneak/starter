<?php

    namespace Uneak\OAuthTwitterServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfiguration;

    class TwitterServerConfiguration extends ServerConfiguration {

        public function configureOptions(OptionsResolver $resolver) {
            parent::configureOptions($resolver);
            $resolver->setDefaults(array(
                'authEndpoint'    => "https://www.twitter.com/v2.0/dialog/oauth",
                'tokenEndpoint'    => "https://graph.twitter.com/v2.0/oauth/access_token",
                'revokeTokenEndpoint'    => "https://graph.twitter.com/v2.0/me/permissions",
            ));

            $resolver->setAllowedTypes('revokeTokenEndpoint', 'string');
        }

        public function getRevokeTokenEndpoint() {
            return $this->getOption('revokeTokenEndpoint');
        }

	}
