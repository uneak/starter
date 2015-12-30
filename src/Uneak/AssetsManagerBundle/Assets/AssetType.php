<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets;

	use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    abstract class AssetType implements AssetTypeInterface {

		public function configureOptions(OptionsResolver $resolver) {

			$resolver->setDefined(array('tag', 'type', 'category', 'dependencies', 'parameters'));
			$resolver->setRequired(array('tag', 'category'));

			$resolver->setAllowedTypes('category', 'string');
			$resolver->setAllowedTypes('tag', 'string');
			$resolver->setAllowedTypes('dependencies', 'array');

			$resolver->setDefaults(array(
				'dependencies' => array(),
				'parameters' => array(),
			));

		}

		public function mergeToAssetsArray(&$assets, $key, $asset) {
			$assets[$key] = $asset;
		}


		public function render(\Twig_Environment $twig, AssetsHelper $assetsHelper, TemplatesManager $templatesManager, array $options) {
			return '';
		}


	}