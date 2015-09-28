<?php

namespace Uneak\OAuthClientBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\OAuthClientBundle\DependencyInjection\Compiler\ServersManagerCompilerPass;
use Uneak\OAuthClientBundle\DependencyInjection\Compiler\ServicesManagerCompilerPass;

class UneakOAuthClientBundle extends Bundle
{

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new ServicesManagerCompilerPass());
    }

}
