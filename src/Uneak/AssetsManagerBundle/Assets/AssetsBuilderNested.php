<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetsBuilderNested extends AssetsBuilder {

		protected $assetsBuilders = array();

		public function addAssetsBuilder(AssetsBuilderInterface $assetsBuilder) {
			array_push($this->assetsBuilders, $assetsBuilder);
		}

		public function removeAssetsBuilder(AssetsBuilderInterface $assetsBuilder) {
			$index = array_search($assetsBuilder, $this->assetsBuilders);
			if ($index !== false) {
				array_splice($this->assetsBuilders, $index, 1);
			}
		}

        protected function _processBuildChildAsset(AssetsBuilderManager $builder) {
            foreach ($this->assetsBuilders as $assetsBuilder) {
                $assetsBuilder->processBuildAssets($builder);
            }
        }

        protected function _processBuildSelfAsset(AssetsBuilderManager $builder) {
			$this->buildAsset($builder, $this);
        }

        public function processBuildAssets(AssetsBuilderManager $builder) {
			if ($this->isAssetsBuilded()) {
				return;
			}

            $this->_processBuildSelfAsset($builder);
            $this->_processBuildChildAsset($builder);

			$this->assetsBuilded = true;
        }
	}