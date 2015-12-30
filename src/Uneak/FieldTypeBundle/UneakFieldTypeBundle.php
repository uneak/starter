<?php

namespace Uneak\FieldTypeBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\FieldTypeBundle\DependencyInjection\Compiler\FieldTypeCompilerPass;

class UneakFieldTypeBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new FieldTypeCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
