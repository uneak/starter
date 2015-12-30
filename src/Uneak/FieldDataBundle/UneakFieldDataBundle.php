<?php

namespace Uneak\FieldDataBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\FieldDataBundle\DependencyInjection\Compiler\FieldDataCompilerPass;

class UneakFieldDataBundle extends Bundle
{

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new FieldDataCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }

}
