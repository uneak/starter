<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;



	class AssetsManager {

		protected $assetTypeManager;
		protected $assets = array();

		public function __construct(AssetTypeManager $assetTypeManager, $configAssets) {
			$this->assetTypeManager = $assetTypeManager;
			foreach ($configAssets as $id => $assetArray) {
				$this->setAsset($id, $assetArray, true);
			}
		}

		public function getAsset($id) {
			if (!$this->hasAsset($id)) {
				// TODO lever une exeption
			}
			if (isset($this->assets[$id])) {
				return $this->assets[$id];
			}
			return null;
		}

		public function setAsset($id, $assetArray, $override = true) {

            if ($this->hasAsset($id)) {
                if ($override) {
                    $assetArray['config'] = array_merge($this->assets[$id]['config'], $assetArray['config']);
                } else {
                    $assetArray['config'] = array_merge($assetArray['config'], $this->assets[$id]['config']);
                }
            }

            $this->assets[$id] = $assetArray;

			return $this;
		}

		public function allAsset() {
			return $this->assets;
		}

		public function hasAsset($id) {
			return isset($this->assets[$id]);
		}

		public function removeAsset($id) {
			unset($this->assets[$id]);
			return $this;
		}

	}