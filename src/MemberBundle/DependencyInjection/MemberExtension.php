<?php

namespace MemberBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MemberExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // set current firewall
        $container->setParameter('member_oauth.firewall_name', $config['firewall_name']);

        if (isset($config['connect'])) {
            $container->setParameter('member_oauth.connect', true);

            $services = $config['connect'];
            if (isset($services['confirmation'])) {
                $container->setParameter('member_oauth.connect.confirmation', $services['confirmation']);
                unset($services['confirmation']);
            }
            $container->setParameter('member_oauth.connect.services', $services);
        } else {
            $container->setParameter('member_oauth.connect', false);
        }


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }
}
