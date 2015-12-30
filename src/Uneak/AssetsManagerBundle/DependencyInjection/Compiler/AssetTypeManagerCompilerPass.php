<?php

namespace Uneak\AssetsManagerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AssetTypeManagerCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {

        $definition = $container->getDefinition('uneak.assettypemanager');
        $taggedServices = $container->findTaggedServiceIds('uneak.assetsmanager.type');


        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'add', array(new Reference($id), $attributes['id'])
                );
            }
        }

    }

}
