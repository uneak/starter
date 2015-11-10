<?php

	namespace ProspectGroupBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use ProspectGroupBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class ProspectGroupBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
