<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets\Js;

	use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
    use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AssetsManagerBundle\Assets\AssetTypeExternal;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class AssetTypeExternalJs extends AssetTypeExternal {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefined(array('src', 'charset', 'language', 'defer', 'event', 'for'));

			$resolver->setRequired('type');

			$resolver->setDefaults(array(
				"type" => "text/javascript",
				"tag" => "script",
				"category" => "AssetExternalJs",
			));


		}


		public function render(\Twig_Environment $twig, AssetsHelper $assetsHelper, TemplatesManager $templatesManager, array $options) {
			$render = array();

			$render[] = '<' . $options['tag'];

			$params = array('src', 'type', 'class', 'charset', 'language', 'defer', 'event', 'for');
			foreach ($params as $param) {
				if (isset($options[$param])) {

					if ($param == 'src') {
						$render[] = $param . '="' . $assetsHelper->getUrl($options[$param]) . '"';
					} else {
						$render[] = $param . '="' . $options[$param] . '"';
					}

				}
			}

			$render[] = '></' . $options['tag'] . '>';

			return implode(' ', $render);
		}

	}