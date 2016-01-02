<?php

	namespace Uneak\FieldSearchBundle\DependencyInjection\Compiler;

    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class FieldSearchCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		if ($container->hasDefinition('uneak.fieldsearchmanager') === false || $container->hasDefinition('form.extension') === false) {
			return;
		}

		$definitionForm = $container->getDefinition('form.extension');
		$types = $definitionForm->getArgument(1);

		$definition = $container->getDefinition('uneak.fieldsearchmanager');
		$taggedServices = $container->findTaggedServiceIds('uneak.fieldsearchmanager.field');

		foreach ($taggedServices as $id => $tagAttributes) {
			foreach ($tagAttributes as $attributes) {
				$types[$attributes['alias_search']] = $id;
				$definition->addMethodCall('addFieldSearch', array($attributes['alias_search'], $attributes['alias_field'], $attributes['field_data']));
			}
		}

		$definitionForm->replaceArgument(1, $types);

	}

}
