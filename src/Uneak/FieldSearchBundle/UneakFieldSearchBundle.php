<?php

namespace Uneak\FieldSearchBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\FieldSearchBundle\DependencyInjection\Compiler\FieldSearchCompilerPass;

class UneakFieldSearchBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new FieldSearchCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
