<?php

	namespace ProspectGroupFieldBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use ProspectGroupFieldBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class ProspectGroupFieldBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
