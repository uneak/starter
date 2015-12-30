<?php

namespace Uneak\ConstraintBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ConstraintCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		if ($container->hasDefinition('uneak.constraintsmanager') === false || $container->hasDefinition('form.extension') === false) {
			return;
		}

		$definitionForm = $container->getDefinition('form.extension');
		$types = $definitionForm->getArgument(1);

		$definition = $container->getDefinition('uneak.constraintsmanager');
		$taggedServices = $container->findTaggedServiceIds('uneak.constraintsmanager.constraint');

		foreach ($taggedServices as $id => $tagAttributes) {
			foreach ($tagAttributes as $attributes) {
				$types[$attributes['alias_config']] = $id;
				$definition->addMethodCall('addConstraint', array($attributes['alias'], $attributes['alias_config'], $attributes['class'], (isset($attributes['label'])) ? $attributes['label'] : null));
			}
		}

		$definitionForm->replaceArgument(1, $types);

	}


}
