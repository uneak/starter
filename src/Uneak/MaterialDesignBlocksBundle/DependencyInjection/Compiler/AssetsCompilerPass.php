<?php
	namespace Uneak\MaterialDesignBlocksBundle\DependencyInjection\Compiler;

	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
	use Symfony\Component\DependencyInjection\Reference;

	class AssetsCompilerPass implements CompilerPassInterface {
		public function process(ContainerBuilder $container) {
			if ($container->hasDefinition('uneak.assetsmanager') === false) {
				return;
			}

			$definition = $container->getDefinition('uneak.assetsmanager');

			$assets = array(
//				"jquery_js" => array(
//					"type" => "externaljs",
//					"build" => true,
//					"config" => array(
//						"src" => "vendor/jquery/dist/jquery.js",
//					),
//				),

				"material_design_lite_js" => array(
					"type" => "externaljs",
					"config" => array(
						"src" => "vendor/material-design-lite/material.js",
					),
				),

				"material_design_lite_css" => array(
					"type" => "externalcss",
					"config" => array(
						"href" => "vendor/material-design-lite/material.css",
					),
				),


			);


			foreach ($assets as $id => $asset) {
				$definition->addMethodCall(
					'set', array($id, $asset, false)
				);
			}
		}
	}