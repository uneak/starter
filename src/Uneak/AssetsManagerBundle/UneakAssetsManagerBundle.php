<?php

namespace Uneak\AssetsManagerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Uneak\AssetsManagerBundle\DependencyInjection\Compiler\AssetsBuilderManagerCompilerPass;
use Uneak\AssetsManagerBundle\DependencyInjection\Compiler\AssetTypeManagerCompilerPass;

class UneakAssetsManagerBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new AssetsBuilderManagerCompilerPass());
		$container->addCompilerPass(new AssetTypeManagerCompilerPass());
	}

}
