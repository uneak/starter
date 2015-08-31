<?php

	namespace Uneak\MaterialDesignBlocksBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use Uneak\MaterialDesignBlocksBundle\DependencyInjection\Compiler\AssetsCompilerPass;
	use Uneak\MaterialDesignBlocksBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class UneakMaterialDesignBlocksBundle extends Bundle {
		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
			$container->addCompilerPass(new AssetsCompilerPass());
		}

	}
