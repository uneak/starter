<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AssetsManagerBundle\Assets\Css;

	use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
    use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\AssetsManagerBundle\Assets\AssetTypeExternal;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class AssetTypeExternalCss extends AssetTypeExternal {

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefined(array('rel', 'type', 'href', 'media', 'title'));

			$resolver->setRequired('type');

			$resolver->setDefaults(array(
				"type" => "text/css",
				"rel" => "stylesheet",
				"tag" => "link",
				"category" => "AssetExternalCss",
			));


		}

		public function render(\Twig_Environment $twig, AssetsHelper $assetsHelper, TemplatesManager $templatesManager, array $options) {
			$render = array();

			$render[] = '<' . $options['tag'];

			$params = array('href', 'rel', 'type', 'media');
			foreach ($params as $param) {
				if (isset($options[$param])) {
					if ($param == 'href') {
						$render[] = $param . '="' . $assetsHelper->getUrl($options[$param]) . '"';
					} else {
						$render[] = $param . '="' . $options[$param] . '"';
					}
				}
			}

			$render[] = '/>';

			return implode(' ', $render);
		}


	}