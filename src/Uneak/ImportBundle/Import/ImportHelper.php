<?php

namespace Uneak\ImportBundle\Import;


use Doctrine\ORM\EntityManagerInterface;
use Uneak\ExecBundle\Exec\Exec;
use Uneak\ImportBundle\Entity\Import;
use Symfony\Component\Console\Output\OutputInterface;
use Uneak\FieldBundle\Field\FieldsHelper;
use Uneak\ProspectBundle\Prospect\ProspectsManager;


class ImportHelper {


    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $exec;

    /**
     * @var FieldsHelper
     */
    private $fieldsHelper;

    /**
     * @var ProspectsManager
     */
    private $prospectsManager;


    public function __construct(EntityManagerInterface $em, Exec $exec, FieldsHelper $fieldsHelper, ProspectsManager $prospectsManager) {
        $this->em = $em;
        $this->exec = $exec;
        $this->fieldsHelper = $fieldsHelper;
        $this->prospectsManager = $prospectsManager;
    }

    public function start(Import $import, $force = false) {
        if ($import->getStatus() != Import::STATUS_READY && $import->getStatus() != Import::STATUS_PROGRESS) {
            return false;
        }

        if ($import->getCurrent() >= $import->getTotal()) {
            $this->complete($import);
            return false;
        }

        $start = false;

        $pId = $import->getProcess();
        if (!$this->exec->isRunning($pId) || $force == true) {
            $pId = $this->exec->command("import:process:start ".$import->getId());
            $import->setProcess($pId);
            $start = true;
        }

        $import->setStatus(Import::STATUS_PROGRESS);
        $this->em->persist($import);
        $this->em->flush();

        return $start;
    }

    public function complete(Import $import) {
        if ($import->getStatus() != Import::STATUS_PROGRESS) {
            return;
        }

        $pId = $import->getProcess();
        $import->setProcess(null);
        $import->setStatus(Import::STATUS_COMPLETE);
        $this->em->persist($import);
        $this->em->flush();

        if ($pId) {
            $this->exec->kill($pId);
        }
    }

    public function stop(Import $import) {
        if ($import->getStatus() != Import::STATUS_PROGRESS) {
            return;
        }

        $pId = $import->getProcess();
        $import->setProcess(null);
        $import->setStatus(Import::STATUS_READY);
        $this->em->persist($import);
        $this->em->flush();

        if ($pId) {
            $this->exec->kill($pId);
        }
    }



    public function persistProspects(Import $import, OutputInterface $output, $countFlush = 10, $max = null) {

        $fields = $import->getFields();
        foreach ($fields as &$field) {
            $field = $this->fieldsHelper->findFieldById($field);
        }

        $datas = $import->getDatas();

        $flushCmpt = 0;
        $tmpMessages = array();

        if (count($fields) && $import->getCurrent() < $import->getTotal()) {
            for ($current = $import->getCurrent(); $current < $import->getTotal(); $current++) {

                $prospect = $this->prospectsManager->createProspect();
                foreach ($datas[$current] as $id => $rowData) {
                    if (isset($fields[$id]) && $fields[$id]) {
                        $this->prospectsManager->setField($prospect, $fields[$id], $rowData);
                    }
                }
                $this->prospectsManager->saveProspect($prospect, false);
                $import->setCurrent($current+1);

                $flushCmpt++;
                if ($flushCmpt >= $countFlush) {
                    $this->em->flush();
                    foreach ($tmpMessages as $tmpMessage) {
                        $output->writeln($tmpMessage);
                    }
                    $flushCmpt = 0;
                    $tmpMessages = array();
                }

                $tmpMessages[] = 'Import '.$import->getId().' success for prospect '.$prospect->getId();

                if ($max !== null) {
                    $max--;
                    if ($max <= 0) {
                        break;
                    }
                }
            }

            $this->em->flush();
            foreach ($tmpMessages as $tmpMessage) {
                $output->writeln($tmpMessage);
            }

        }

        $output->writeln('TEST END : '.$import->getCurrent().' >= '.$import->getTotal());
        if ($import->getCurrent() >= $import->getTotal()) {
            $output->writeln('Import '.$import->getId().' COMPLETE');
            $this->complete($import);
        }

    }



}
