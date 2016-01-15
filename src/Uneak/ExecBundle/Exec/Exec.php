<?php

namespace Uneak\ExecBundle\Exec;

use Symfony\Component\HttpKernel\KernelInterface;

class Exec
{

	/**
	 * @var \Symfony\Component\HttpKernel\KernelInterface
	 */
	private $kernel;


	public function __construct(KernelInterface $kernel) {
		$this->kernel = $kernel;
	}

	public function command($command, $output = null) {
		$rootDir = $this->kernel->getRootDir().'/console';
		$env = $this->kernel->getEnvironment();
		$cmd = 'php '.$rootDir.' '.$command." --env=".$env;
		return $this->exec($cmd, $output);
	}

	public function exec($command, $output = null) {
		if (!$output) {
			$output = $this->kernel->getLogDir().'/BG_COMMAND_'.uniqid().".txt";
//			$output = '/dev/null'; // aucun output
		}
//		$cmd = 'nohup '.$command;
		$cmd = $command;
		exec(sprintf("%s > %s 2>&1 & echo $!", $cmd, $output), $op);
		return (int)$op[0];
	}

	public function isRunning($pId) {
		$command = 'ps -p '.$pId;
		exec($command, $op);
		return isset($op[1]);
	}

	public function kill($pId) {
		$command = 'kill '.$pId;
		exec($command);
		return !$this->isRunning($pId);
	}

}
