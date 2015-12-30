<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsBuilder implements AssetsBuilderInterface {

		protected $assetsBuilded = false;

        public function buildAsset(AssetsBuilderManager $builder, $parameters) {
		}

        public function processBuildAssets(AssetsBuilderManager $builder) {
			if ($this->isAssetsBuilded()) {
				return;
			}

			$this->buildAsset($builder, $this);
			$this->assetsBuilded = true;
        }

		public function isAssetsBuilded() {
			return $this->assetsBuilded;
		}
	}