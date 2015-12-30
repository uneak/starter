<?php

	namespace Uneak\FieldTypeBundle\DependencyInjection\Compiler;

    use Symfony\Component\DependencyInjection\ContainerBuilder;
    use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class FieldTypeCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		if ($container->hasDefinition('uneak.fieldtypesmanager') === false || $container->hasDefinition('form.extension') === false) {
			return;
		}

		$definitionForm = $container->getDefinition('form.extension');
		$types = $definitionForm->getArgument(1);

		$definition = $container->getDefinition('uneak.fieldtypesmanager');
		$taggedServices = $container->findTaggedServiceIds('uneak.fieldtypesmanager.field');

		foreach ($taggedServices as $id => $tagAttributes) {
			foreach ($tagAttributes as $attributes) {
				$types[$attributes['alias_config']] = $id;
				$definition->addMethodCall('addFieldType', array($attributes['alias_config'], $attributes['alias_field'], $attributes['field_data'], (isset($attributes['label'])) ? $attributes['label'] : null));
			}
		}

		$definitionForm->replaceArgument(1, $types);

	}

}
