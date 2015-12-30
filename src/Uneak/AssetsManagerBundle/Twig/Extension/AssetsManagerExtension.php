<?php

	namespace Uneak\AssetsManagerBundle\Twig\Extension;

	use Symfony\Component\DependencyInjection\ContainerInterface;
	use Twig_Extension;
	use Twig_Function_Method;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class AssetsManagerExtension extends Twig_Extension {

		private $twig;
		private $environment;
		private $assetsBuilderManager;
        private $templatesManager;
		private $container;

		public function __construct(AssetsBuilderManager $assetsBuilderManager, TemplatesManager $templatesManager, $twig, ContainerInterface $container) {
			$this->assetsBuilderManager = $assetsBuilderManager;
			$this->templatesManager = $templatesManager;
			$this->twig = $twig;
			$this->container = $container;
		}

		public function initRuntime(\Twig_Environment $environment) {
			$this->environment = $environment;
		}

		public function getFunctions() {
			$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

			return array(
				'renderAssets'   => new Twig_Function_Method($this, 'renderAssetsFunction', $options)
			);
		}

		public function renderAssetsFunction($category = null) {
			$string = "";
            $assets = $this->assetsBuilderManager->getAssets($category);
            $assetsHelper = $this->container->get('templating.helper.assets');

			foreach ($assets as $asset) {
				if (is_array($asset)) {
					foreach ($asset as $assetItem) {
						$string .= $assetItem->getObject()->render($this->twig, $assetsHelper, $this->templatesManager, $assetItem->getOptions());
					}
				} else {
					$string .= $asset->getObject()->render($this->twig, $assetsHelper, $this->templatesManager, $asset->getOptions());
				}
			}

			return $string;
		}

		public function getName() {
			return 'uneak_assetsmanager';
		}

	}
