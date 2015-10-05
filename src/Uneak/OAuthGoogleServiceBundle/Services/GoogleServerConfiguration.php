<?php

    namespace Uneak\OAuthGoogleServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfiguration;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2Configuration;

    class GoogleServerConfiguration extends ServerOAuth2Configuration {

        public function configureOptions(OptionsResolver $resolver) {
            parent::configureOptions($resolver);
            $resolver->setDefaults(array(
                'authEndpoint'    => "https://www.google.com/v2.0/dialog/oauth",
                'tokenEndpoint'    => "https://graph.google.com/v2.0/oauth/access_token",
                'revokeTokenEndpoint'    => "https://graph.google.com/v2.0/me/permissions",
            ));

            $resolver->setAllowedTypes('revokeTokenEndpoint', 'string');
        }

        public function getRevokeTokenEndpoint() {
            return $this->getOption('revokeTokenEndpoint');
        }

	}
