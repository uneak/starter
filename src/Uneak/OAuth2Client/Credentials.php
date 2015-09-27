<?php

namespace Uneak\OAuth2Client;


use Symfony\Component\OptionsResolver\OptionsResolver;

class Credentials implements CredentialsInterface {


    protected $options;

    public function __construct(array $options = array()) {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefined("user");
        $resolver->setDefaults(array(
            'clientId'    => null,
            'clientSecret'    => null,
            'certificateFile' => null
        ));

        $resolver->setRequired(array('clientId', 'clientSecret'));
        $resolver->setAllowedTypes('clientId', 'string');
        $resolver->setAllowedTypes('clientSecret', 'string');
        $resolver->setAllowedTypes('certificateFile', array('null', 'string'));
        $resolver->setNormalizer('certificateFile', function ($options, $value) {
            if (!empty($value) && !is_file($value)) {
                throw new InvalidArgumentException('The certificate file was not found', InvalidArgumentException::CERTIFICATE_NOT_FOUND);
            }
            return $value;
        });

    }

    public function getOption($key) {
        return $this->options[$key];
    }

	public function getClientId() {
        return $this->options['clientId'];
	}

	public function getClientSecret() {
		return $this->options['clientSecret'];
	}

	public function getCertificateFile() {
		return $this->options['certificateFile'];
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
