<?php
	namespace Uneak\MaterialDesignBlocksBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;

	class TemplatesCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('uneak.templatesmanager') === false) {
				return;
			}

			$definition = $container->getDefinition('uneak.templatesmanager');

			$templates = array(
				"block_card_script" => "UneakMaterialDesignBlocksBundle:Block:card_script.html.twig",
				"block_card_template" => "UneakMaterialDesignBlocksBundle:Block:card.html.twig",
			);

			foreach ($templates as $id => $template) {
				$definition->addMethodCall(
					'set', array($id, $template, false)
				);
			}
		}
	}