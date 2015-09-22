<?php
	namespace MemberBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;
	use Symfony\Component\Yaml\Yaml;

	class FOSUserCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('member_oauth.security.oauth_utils') === false) {
				return;
			}

			$firewallName = $container->getParameter('member_oauth.firewall_name');
			$oauthUtils = $container->getDefinition('member_oauth.security.oauth_utils');
			$oauthUtils->addMethodCall('setResourceOwnerMap', array(new Reference('hwi_oauth.resource_ownermap.'.$firewallName)));


			if ($container->hasParameter('member_oauth.connect.services')) {
				$services = $container->getParameter('member_oauth.connect.services');
				foreach ($services as $key => $serviceId) {
					$container->setAlias('member_oauth.'.str_replace('_', '.', $key), $serviceId);
				}
			}


		}
	}