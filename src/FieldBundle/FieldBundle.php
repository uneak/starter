<?php

	namespace FieldBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use FieldBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class FieldBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
