<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

	class ServiceUser extends Configuration implements ServiceUserInterface {

		protected $service;

		public function __construct(ServiceInterface $service, array $options = array()) {
			$this->service = $service;
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'id'         => null,
				'first_name' => null,
				'last_name'  => null,
				'link'       => null,
				'username'   => null,
				'email'      => null,
				'picture'    => null,
				'gender'     => null,
				'locale'     => null,
			));

			$resolver->setRequired('id');
			$resolver->setAllowedTypes('service', 'string');
			$resolver->setAllowedTypes('id', 'string');
		}


		protected function adapter(array $data, array $path) {
			foreach ($path as $internal => $external) {
				$externalPath = explode('.', $external);
				$value = $data;
				for($i=0; $i < count($externalPath); $i++) {
					$value = $value[$externalPath[$i]];
				}
				$path[$internal] = $value;
			}
			return $path;
		}

		/**
		 * @param array $data
		 */
		public function setData(array $data) {
			$this->options = $this->adapter($data, array(
				'id'         => 'id',
				'first_name' => 'first_name',
				'last_name'  => 'last_name',
				'link'       => 'link',
				'username'   => 'username',
				'email'      => 'email',
				'picture'    => 'picture',
				'gender'     => 'gender',
				'locale'     => 'locale',
			));
		}



		public function setTokenData(TokenInterface $token) {

		}

		protected function resolve() {
			$this->options = $this->resolver->resolve($this->options);
			$this->resolved = true;
		}




		/**
		 * @return mixed
		 */
		public function getId() {
			return $this->getOption('id');
		}

		/**
		 * @return mixed
		 */
		public function getFirstName() {
			return $this->getOption('first_name');
		}

		/**
		 * @return mixed
		 */
		public function getLastName() {
			return $this->getOption('last_name');
		}

		/**
		 * @return mixed
		 */
		public function getLink() {
			return $this->getOption('link');
		}

		/**
		 * @return mixed
		 */
		public function getUsername() {
			return $this->getOption('username');
		}

		/**
		 * @return mixed
		 */
		public function getEmail() {
			return $this->getOption('email');
		}

		/**
		 * @return mixed
		 */
		public function getPicture() {
			return $this->getOption('picture');
		}

		/**
		 * @return mixed
		 */
		public function getGender() {
			return $this->getOption('gender');
		}

		/**
		 * @return mixed
		 */
		public function getLocale() {
			return $this->getOption('locale');
		}


	}

