<?php

	namespace Uneak\PortoAdminBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use Uneak\PortoAdminBundle\DependencyInjection\Compiler\AssetsCompilerPass;
	use Uneak\PortoAdminBundle\DependencyInjection\Compiler\BowerCompilerPass;
    use Uneak\PortoAdminBundle\DependencyInjection\Compiler\LiipImagineCompilerPass;
    use Uneak\PortoAdminBundle\DependencyInjection\Compiler\PortoAdminCompilerPass;
	use Uneak\PortoAdminBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class UneakPortoAdminBundle extends Bundle {
		public function build(ContainerBuilder $container) {
			parent::build($container);
			$reflected = new \ReflectionClass($this);
			$container->addCompilerPass(new BowerCompilerPass($reflected->getShortName()));
			$container->addCompilerPass(new AssetsCompilerPass());
			$container->addCompilerPass(new TemplatesCompilerPass());
			$container->addCompilerPass(new PortoAdminCompilerPass());
			$container->addCompilerPass(new LiipImagineCompilerPass());
		}

	}
