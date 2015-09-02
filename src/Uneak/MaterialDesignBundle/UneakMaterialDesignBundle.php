<?php

	namespace Uneak\MaterialDesignBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use Uneak\MaterialDesignBundle\DependencyInjection\Compiler\AssetsCompilerPass;
	use Uneak\MaterialDesignBundle\DependencyInjection\Compiler\BowerCompilerPass;
	use Uneak\MaterialDesignBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class UneakMaterialDesignBundle extends Bundle {
		public function build(ContainerBuilder $container) {
			parent::build($container);
			$reflected = new \ReflectionClass($this);
			$container->addCompilerPass(new BowerCompilerPass($reflected->getShortName()));
			$container->addCompilerPass(new AssetsCompilerPass());
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
