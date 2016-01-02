<?php
	namespace FieldBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;
	use Symfony\Component\Yaml\Yaml;

	class TemplatesCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('uneak.templatesmanager') === false) {
				return;
			}

			$definition = $container->getDefinition('uneak.templatesmanager');
			$templates = Yaml::parse(file_get_contents(__DIR__.'/../../Resources/config/templates.yml'));

			if ($templates) {
				foreach ($templates as $id => $template) {
					$definition->addMethodCall(
						'setTemplate', array($id, $template, false)
					);
				}				
			}

		}
	}