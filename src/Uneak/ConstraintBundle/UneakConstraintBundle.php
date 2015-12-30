<?php

namespace Uneak\ConstraintBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\ConstraintBundle\DependencyInjection\Compiler\ConstraintCompilerPass;

class UneakConstraintBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new ConstraintCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
