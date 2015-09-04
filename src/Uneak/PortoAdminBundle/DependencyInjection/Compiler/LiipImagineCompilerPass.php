<?php
	namespace Uneak\PortoAdminBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;
	use Symfony\Component\Yaml\Yaml;

	class LiipImagineCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('liip_imagine.filter.configuration') === false) {
				return;
			}

			$definition = $container->getDefinition('liip_imagine.filter.configuration');
			$filterSet = Yaml::parse(file_get_contents(__DIR__.'/../../Resources/config/liip_imagine.yml'));

			foreach ($filterSet as $id => $filter) {
				$definition->addMethodCall(
					'set', array($id, $filter)
				);
			}
		}
	}