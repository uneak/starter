<?php

	namespace MemberBundle;

	use MemberBundle\DependencyInjection\Compiler\FOSUserCompilerPass;
	use MemberBundle\DependencyInjection\Compiler\HwiOauthCompilerPass;
	use MemberBundle\DependencyInjection\Compiler\TemplatesCompilerPass;
	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\HttpKernel\Bundle\Bundle;

	class MemberBundle extends Bundle {

		public function build(ContainerBuilder $container) {
			parent::build($container);
			$container->addCompilerPass(new TemplatesCompilerPass());
			$container->addCompilerPass(new FOSUserCompilerPass());
			$container->addCompilerPass(new HwiOauthCompilerPass());
		}

	}
