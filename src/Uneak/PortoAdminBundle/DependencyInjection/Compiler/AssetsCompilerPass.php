<?php
	namespace Uneak\PortoAdminBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;
	use Symfony\Component\Yaml\Yaml;

	class AssetsCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('uneak.assetsmanager') === false) {
				return;
			}

			$definition = $container->getDefinition('uneak.assetsmanager');
			$assets = Yaml::parse(file_get_contents(__DIR__.'/../../Resources/config/assets.yml'));

			foreach ($assets as $id => $asset) {
				$definition->addMethodCall(
					'setAsset', array($id, $asset, false)
				);
			}
		}
	}