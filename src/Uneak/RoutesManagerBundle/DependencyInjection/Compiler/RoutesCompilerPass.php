<?php

namespace Uneak\RoutesManagerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RoutesCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {

        if ($container->hasDefinition('uneak.routesmanager.nestedmanager') === false) {
            return;
        }
        $definition = $container->getDefinition('uneak.routesmanager.nestedmanager');
        $taggedServices = $container->findTaggedServiceIds('uneak.routesmanager.route');

        foreach ($taggedServices as $id => $tagAttributes) {
            $adminDef = $container->getDefinition($id);
            $adminDef->setConfigurator(array(
                new Reference('uneak.routesmanager.nested.config'),
                'configure'
            ));

            $adminDef->addMethodCall('initialize');
            $definition->addMethodCall('addNestedRoute', array(new Reference($id)));
        }

    }

}
