<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AssetsManagerBundle\Assets\Asset;

	abstract class AssetTypeInternal extends AssetType {

        public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefined(array('content', 'template'));
		}

		public function mergeToAssetsArray(&$assets, $key, $asset) {
			if (!isset($assets[$key])) {
				$assets[$key] = $asset;
			} elseif (is_array($assets[$key])) {
				array_push($assets[$key], $asset);
			} else {
				$prevAsset = $assets[$key];
				unset($assets[$key]);
				$assets[$key] = array($prevAsset, $asset);
			}
		}

	}