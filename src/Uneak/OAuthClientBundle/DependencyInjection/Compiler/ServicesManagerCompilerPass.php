<?php

namespace Uneak\OAuthClientBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ServicesManagerCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {

        $definition = $container->getDefinition('uneak.oauth.servicesmanager');
        $taggedServices = $container->findTaggedServiceIds('uneak.oauth.service');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $override = (isset($attributes['override'])) ? $attributes['override'] : null;
                if (is_null($override)) {
                    $definition->addMethodCall('addService', array($attributes['alias'], $id));
                } else {
                    $definition->addMethodCall('addService', array($attributes['alias'], $id, $override));
                }
            }
        }

    }

}
