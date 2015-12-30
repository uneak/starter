<?php

	namespace Uneak\FieldDataBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FieldDataCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		if ($container->hasDefinition('uneak.fielddatasmanager') === false) {
			return;
		}

		$definition = $container->getDefinition('uneak.fielddatasmanager');
		$taggedServices = $container->findTaggedServiceIds('uneak.fielddatasmanager.fielddata');

		foreach ($taggedServices as $id => $tagAttributes) {
			foreach ($tagAttributes as $attributes) {
				$taggedDefinition = $container->getDefinition($id);
				$class = $taggedDefinition->getClass();
				$definition->addMethodCall('addFieldData', array($attributes['alias'], $class, (isset($attributes['label'])) ? $attributes['label'] : null));
			}
		}

	}

}
