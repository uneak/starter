<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	class Asset {

		protected $object;
		protected $options;

		public function __construct(AssetTypeInterface $object, array $options) {
            $this->object = $object;
            $this->options = $options;
		}

        /**
         * @return AssetTypeInterface
         */
        public function getObject() {
            return $this->object;
        }

        /**
         * @return array
         */
        public function getOptions() {
            return $this->options;
        }

        public function getCategory() {
            return $this->options["category"];
        }

        public function getDependencies() {
            return $this->options["dependencies"];
        }

	}