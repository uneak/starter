<?php

namespace Uneak\MaterialDesignBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class BowerCompilerPass implements CompilerPassInterface {

    private $bundleName;

    public function __construct($bundleName) {
        $this->bundleName = $bundleName;
    }

    public function process(ContainerBuilder $container) {
        if ($container->hasDefinition('sp_bower.bower_manager') === false) {
            return;
        }
        $bowerManager = $container->getDefinition('sp_bower.bower_manager');

        $def = new DefinitionDecorator('sp_bower.filesystem_cache');
        $def->replaceArgument(0, "%kernel.root_dir%/cache");
        $container->setDefinition(($defId = 'sp_bower.filesystem_cache.' . $this->bundleName), $def);

        $configuration = new Definition('%sp_bower.bower.configuration.class%');
        $configuration->addArgument(__DIR__."/../../Resources/config");
        $configuration->addMethodCall('setAssetDirectory', array("%kernel.root_dir%/../web/vendor"));
        $configuration->addMethodCall('setJsonFile', array("bower.json"));
        $configuration->addMethodCall('setEndpoint', array("https://bower.herokuapp.com"));
        $configuration->addMethodCall('setCache', array(new Reference($defId)));
        $bowerManager->addMethodCall('addBundle', array($this->bundleName, $configuration));

    }





}
