<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;


	class AssetTypeManager {

		protected $assetstypes = array();

		public function all() {
			return $this->assetstypes;
		}

		public function add(AssetTypeInterface $asset, $id) {
			$this->assetstypes[$id] = $asset;
			return $this;
		}

		public function get($id) {
			return $this->assetstypes[$id];
		}

		public function has($id) {
			return isset($this->assetstypes[$id]);
		}

		public function remove($id) {
			if (isset($this->assetstypes[$id])) {
				unset($this->assetstypes[$id]);
			}
			return $this;
		}


	}