<?php

	namespace FieldGroupBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use FieldGroupBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class FieldGroupBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
