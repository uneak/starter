<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;

	class ServiceUser extends Configuration implements ServiceUserInterface {

		protected $data;

		public function __construct(array $options = array()) {
			$this->data = $options;
			parent::__construct();
		}

		public function configureOptions(OptionsResolver $resolver) {
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
		 * @return array
		 */
		public function getData() {
			return $this->data;
		}

		/**
		 * @param array $data
		 */
		public function setData(array $data) {
			$this->data = $data;
			$this->resolved = false;
		}


		protected function resolve() {
			$options = $this->adapter($this->getData(), array(
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

			$this->options = $this->resolver->resolve($options);
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

