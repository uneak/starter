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
	use Uneak\AssetsManagerBundle\Assets\AssetTypeInternal;
	use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class AssetTypeInternalCss extends AssetTypeInternal {

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);

			$resolver->setDefined('media');

			$resolver->setDefaults(array(
				"type" => "text/css",
				"tag" => "style",
				"category" => "AssetInternalCss",
			));


		}


		public function render(\Twig_Environment $twig, AssetsHelper $assetsHelper, TemplatesManager $templatesManager, array $options) {

			if (isset($options['content'])) {

				$render = array();
				$render[] = '<' . $options['tag'];
				$params = array('type', 'media');
				foreach ($params as $param) {
					if (isset($options[$param])) {
						$render[] = $param . '="' . $options[$param] . '"';
					}
				}
				$render[] = '>';
				$render[] = $options['content'];
				$render[] = '</' . $options['tag'] . '>';


				return $twig->render(implode(' ', $render), $options['parameters']);

			} else if (isset($options['template'])) {

                $template = ($templatesManager->hasTemplate($options['template'])) ? $templatesManager->getTemplate($options['template']) : $options['template'];
				return $twig->render($template, $options['parameters']);

			}

			return '';

		}


	}