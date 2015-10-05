<?php

    namespace Uneak\OAuthFacebookServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2Configuration;

    class FacebookServerConfiguration extends ServerOAuth2Configuration {

        public function configureOptions(OptionsResolver $resolver) {
            parent::configureOptions($resolver);
            $resolver->setDefaults(array(
                'authEndpoint'    => "https://www.facebook.com/v2.0/dialog/oauth",
                'tokenEndpoint'    => "https://graph.facebook.com/v2.0/oauth/access_token",
                'revokeTokenEndpoint'    => "https://graph.facebook.com/v2.0/me/permissions",
            ));

            $resolver->setAllowedTypes('revokeTokenEndpoint', 'string');
        }

        public function getRevokeTokenEndpoint() {
            return $this->getOption('revokeTokenEndpoint');
        }

	}
