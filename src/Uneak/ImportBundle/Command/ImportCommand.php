<?php

	namespace Uneak\ImportBundle\Command;

	use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
	use Symfony\Component\Console\Input\InputArgument;
	use Symfony\Component\Console\Input\InputInterface;
	use Symfony\Component\Console\Output\OutputInterface;
	use Uneak\ImportBundle\Entity\Import;

	class ImportCommand extends ContainerAwareCommand
	{
		protected function configure()
		{
			$this
				->setName('import:process:start')
				->setDescription('Import start process')
				->addArgument(
					'id',
					InputArgument::REQUIRED,
					'Import ID'
				)
			;
		}

		protected function execute(InputInterface $input, OutputInterface $output)
		{
			$id = $input->getArgument('id');
			$em = $this->getContainer()->get('doctrine.orm.entity_manager');
			$importHelper = $this->getContainer()->get('uneak.import.helper');
			$import = $em->getRepository('UneakImportBundle:Import')->find($id);
			$importHelper->persistProspects($import, $output, round($import->getTotal() / 200), 1000);

			if ($import->getStatus() == Import::STATUS_PROGRESS) {
				$importHelper->start($import, true);
			}

		}
	}