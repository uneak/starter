<?php

namespace ProspectBundle\Controller;

use Ddeboer\DataImport\Reader\CsvReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Uneak\FieldBundle\Entity\Field;
use Uneak\FieldGroupBundle\Entity\FieldGroup;
use Uneak\FieldSearchBundle\Field\SearchType\SearchType;
use Uneak\FieldSearchBundle\Form\FieldSearchType;
use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
use Uneak\PortoAdminBundle\Blocks\Form\Form;
use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\PortoAdminBundle\PNotify\PNotify;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class ProspectAdminController extends LayoutEntityController
{


    public function indexAction(FlattenRoute $route)
    {

        $request = $this->get('request');

        $blockBuilder = $this->get("uneak.blocksmanager.builder");
        $blockBuilder->addBlock("layout", "block_main_interface");

        $layout = $this->get("uneak.admin.page.entity.layout");
        $layout->setLayout($blockBuilder->getBlock("layout"));
        $layout->buildEntityLayout($route);
        $layout->buildGridPage($route);

        $gridNested = $route->getNestedRoute();
        $crudHandler = $route->getHandler();




        $query = array();
        $selectQuery = array();
        $fieldColumns = $crudHandler->getColumns($route);
        $columns = array_merge($gridNested->getColumns(), $fieldColumns);

        foreach ($columns as $column) {
            $selectQuery[] = $column['name'];
        }
        $query['fields'] = join(',', $selectQuery);


        $form = $this->createForm(new FieldSearchType($fieldColumns));
        $form->add('submit', 'submit', array('label' => 'Filtrer'));


        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                foreach ($form as $key => $child) {
                    $type = $child->getConfig()->getType()->getInnerType();
                    if ($type instanceof SearchType) {
                        $data = $child->getData();
                        if ($data['enabled'] == true) {
                            $type->buildQuery($query, $key, $data);
                        }
                    }
                }


            } else {
                $this->addFlash('error', new PNotify(array(
                    'type' => 'error',
                    'title' => 'Formulaire',
                    'text' => 'Votre formulaire est invalide.',
                    'shadow' => true,
                    'stack' => 'stack-bar-bottom'
                )));
            }
        }

        $formsManager = $this->get('uneak.formsmanager');
        $formView = $formsManager->createView($form);


        $formBlock = new Form($formView);
        $formBlock->addClass("form-horizontal");
        $formBlock->addClass("form-bordered");

        $panel = new Panel();
        $panel->setTitle("Filtres");
        $panel->setCollapsed(($request->getMethod() != Request::METHOD_POST));
        $panel->setDismiss(true);
        $panel->setToggle(true);
        $panel->addBlock($formBlock);

        $layout->getSubLayoutContentBody()->addBlock($panel, 'filter');






        $datatable = new Datatable();
        $datatable->setAjax($route->getChild('_grid')->getRoutePath());
        if (count($query)) {
            $datatable->setQuery($query);
        }
        $datatable->setColumns($columns);

        $layout->getSubLayoutContentBody()->addBlock($datatable, 'datatable');


        return $blockBuilder->renderResponse("layout");
    }

    public function importCsvAction(FlattenRoute $route, Request $request)
    {
        $blockBuilder = $this->get("uneak.blocksmanager.builder");
        $blockBuilder->addBlock("layout", "block_main_interface");

        $layout = $this->get("uneak.admin.page.entity.layout");
        $layout->setLayout($blockBuilder->getBlock("layout"));
        $layout->buildEntityLayout($route);

        $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));

        $form = $this->createFormBuilder()
            ->add('file', 'file', array(
                'label' => 'Fichier CSV',
                'constraints' => new File(array(
                    'mimeTypes' => array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv'),
                    'mimeTypesMessage' => "Please upload a valid CSV",
                ))
            ))
            ->add('separator', 'text', array(
                'label' => 'Séparateur',
                'data' => ';',
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 1, 'max' => 1)),
                )
            ))
            ->add('submit', 'submit', array('label' => 'Importer'))
            ->getForm();

        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $fileField = $form->get('file')->getData();
                if ($fileField) {
                    $destPath = $this->get('kernel')->getRootDir() . '/../web/uploads/import';
                    @mkdir($destPath, 0777);

                    $destFile = uniqid('CSV');
                    $contenu = file_get_contents($fileField);
                    $fichier = fopen($destPath . '/' . $destFile, 'w');
                    fputs($fichier, $this->_normalizeCsv($contenu));
                    fclose($fichier);

                    $session = $this->get('session');
                    $session->set('import_csv_file', $destPath . '/' . $destFile);
                    $session->set('import_csv_separator', $form->get('separator')->getData());

                    return $this->redirect($route->getChild('proceed')->getRoutePath());
                }


            } else {
                $this->addFlash('error', new PNotify(array(
                    'type' => 'error',
                    'title' => 'Formulaire',
                    'text' => 'Votre formulaire est invalide.',
                    'shadow' => true,
                    'stack' => 'stack-bar-bottom'
                )));
            }
        }

        $formsManager = $this->get('uneak.formsmanager');
        $formView = $formsManager->createView($form);
        $layout->buildFormPage($formView, "Importation CSV");

        return $blockBuilder->renderResponse("layout");
    }


    private function _normalizeCsv($contenu)
    {
        $encoding = mb_detect_encoding($contenu);
        if ($encoding != 'UTF-8') {
            $contenu = mb_convert_encoding($contenu, 'UTF-8');
        }
        define('CR', "\r");          // Carriage Return: Mac
        define('LF', "\n");          // Line Feed: Unix
        define('CRLF', "\r\n");      // Carriage Return and Line Feed: Windows
        define('BR', '<br />' . LF); // HTML Break
        $contenu = str_replace(CRLF, LF, $contenu);
        $contenu = str_replace(CR, LF, $contenu);
        // Don't allow out-of-control blank lines
        $contenu = preg_replace("/\n{2,}/", LF . LF, $contenu);
        $contenu = utf8_encode($contenu);
        return $contenu;
    }




    public function importCsvProceedAction(FlattenRoute $route, Request $request)
    {
        $session = $this->get('session');
        $filePath = $session->get('import_csv_file');
        $separator = $session->get('import_csv_separator');

        $file = new \SplFileObject($filePath);

        $reader = new CsvReader($file, $separator);
        $reader->setHeaderRowNumber(0);

        /** @var $group FieldGroup */
        $group = $route->getParameter('groups')->getParameterSubject();


        $em = $this->get('doctrine.orm.entity_manager');
        $fieldHelper = $this->get('uneak.field.helper');
        $prospectManager = $this->get('uneak.prospectmanager');

        $dbFields = $fieldHelper->findFieldsByGroup($group);

        $choiceFields = array();
        /** @var $dbField Field*/
        foreach ($dbFields as $dbField) {
            $choiceFields[$dbField->getId()] = $dbField->getLabel();
        }


        $choices = array(
            'Associer au champs' => $choiceFields,
            'Action' => array(
                '__create__' => 'Créer',
                '__unuse__' => 'Ne pas utiliser',
            ),
        );


        $blockBuilder = $this->get("uneak.blocksmanager.builder");
        $blockBuilder->addBlock("layout", "block_main_interface");

        $layout = $this->get("uneak.admin.page.entity.layout");
        $layout->setLayout($blockBuilder->getBlock("layout"));
        $layout->buildEntityLayout($route);

        $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));

        $form = $this->createFormBuilder();
        foreach ($reader->getColumnHeaders() as $column) {
            $form->add($column, 'choice', array(
                'label' => $column,
                'choices' => $choices,
                'data' => '__unuse__',
                'required' => true
            ));
        }
        $form->add('submit', 'submit', array('label' => 'Proceed'));
        $form = $form->getForm();

        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $data = $request->request->get('form');
                $fields = array();
                foreach ($data as $key => $value) {
                    if ($value == '__create__') {
                        $field = $fieldHelper->createField($group, $key);
                        $fieldHelper->saveField($field);
                        $fields[$key] = $field;
                    } else if ($value != '__unuse__' && $value != '') {
                        $field = $fieldHelper->findFieldById($value);
                        $fields[$key] = $field;
                    }
                }

                $cmpt = 0;
                if (count($fields)) {
                    foreach ($reader as $row) {
                        $prospect = $prospectManager->createProspect();
                        foreach ($row as $id => $rowData) {
                            $prospectManager->setField($prospect, $fields[$id], $rowData);
                        }
                        $prospectManager->saveProspect($prospect, false);
                        $cmpt++;
                    }
                    $em->flush();
                }



                $this->addFlash('info', new PNotify(array(
                    'type' => 'info',
                    'title' => 'Formulaire',
                    'text' => 'Import '.$cmpt.' success',
                    'shadow' => true,
                    'stack' => 'stack-bar-bottom'
                )));


                return $this->redirect($route->getChild('*/index')->getRoutePath());

            } else {
                $this->addFlash('error', new PNotify(array(
                    'type' => 'error',
                    'title' => 'Formulaire',
                    'text' => 'Votre formulaire est invalide.',
                    'shadow' => true,
                    'stack' => 'stack-bar-bottom'
                )));
            }
        }

        $formsManager = $this->get('uneak.formsmanager');
        $formView = $formsManager->createView($form);
        $layout->buildFormPage($formView, "Ajouter une contrainte");

        return $blockBuilder->renderResponse("layout");
    }

}