<?php
	namespace Uneak\PortoAdminBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Definition;
	use Symfony\Component\DependencyInjection\Reference;
	use Symfony\Component\Yaml\Yaml;
	use Uneak\PortoAdminBundle\Menu\Factory\BadgeExtension;

	class PortoAdminCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('knp_menu.factory') === false) {
				return;
			}

			$definition = $container->getDefinition('knp_menu.factory');
			$definition->addMethodCall('addExtension', array(new Definition('Uneak\PortoAdminBundle\Menu\Factory\BadgeExtension')));

		}
	}