<?php

    namespace Uneak\AssetsManagerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AssetsBuilderManagerCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {

        $definition = $container->getDefinition('uneak.assetsbuildermanager');
        $taggedServices = $container->findTaggedServiceIds('uneak.assetsmanager.assets');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall('addAssetsBuilder', array(new Reference($id)));
            }
        }

    }

}
