<?php

	namespace Uneak\AssetsManagerBundle\Assets;

	interface AssetsBuilderInterface {
        public function buildAsset(AssetsBuilderManager $builder, $parameters);
        public function processBuildAssets(AssetsBuilderManager $builder);
		public function isAssetsBuilded();
	}
