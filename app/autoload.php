<?php

	use Doctrine\Common\Annotations\AnnotationRegistry;
	use Composer\Autoload\ClassLoader;

	/**
	 * @var ClassLoader $loader
	 */
	$loader = require __DIR__ . '/../vendor/autoload.php';

	AnnotationRegistry::registerLoader(array($loader, 'loadClass'));


	$loader->set('Uneak\\AssetsManagerBundle', array('/Users/marc/Workspace/uneak/assetsManagerBundle'));
	$loader->set('Uneak\\BlocksManagerBundle', array('/Users/marc/Workspace/uneak/blocksManagerBundle'));
	$loader->set('Uneak\\FormsManagerBundle', array('/Users/marc/Workspace/uneak/formsManagerBundle'));
	$loader->set('Uneak\\RoutesManagerBundle', array('/Users/marc/Workspace/uneak/routesManagerBundle'));


	return $loader;
