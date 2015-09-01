<?php

namespace Uneak\MaterialDesignBlocksBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class UneakMaterialDesignBlocksExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


//        $parameters = Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/parameters.yml'));
//        foreach ($parameters as  $key => $value) {
//            $container->setParameter($key, array_replace_recursive($value, $container->getParameter($key)));
//        }


        $location = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new Loader\YamlFileLoader($container, $location);
        $loader->load('services.yml');
        $loader->load('templates.yml');



    }
}
