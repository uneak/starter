<?php

namespace Uneak\RoutesManagerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\RoutesManagerBundle\DependencyInjection\Compiler\RoutesCompilerPass;

class UneakRoutesManagerBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new RoutesCompilerPass());
    }
}
