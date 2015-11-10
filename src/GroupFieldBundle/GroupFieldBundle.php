<?php

	namespace GroupFieldBundle;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;
	use GroupFieldBundle\DependencyInjection\Compiler\TemplatesCompilerPass;

	class GroupFieldBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
		}

	}
