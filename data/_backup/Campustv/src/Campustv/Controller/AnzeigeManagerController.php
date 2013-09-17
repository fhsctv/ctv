<?php

namespace Campustv\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Campustv\Form\Form\DeleteForm;

use Campustv\Model\Entity;

class AnzeigeManagerController extends AbstractActionController {

    /**
     * GET- parameters are defined in the router of the module.config.php.
     * The id - parameter determines which slide has to be shown
     */
    const PARAM_ID      = 'id';

    /**
     * GET- parameters are defined in the router of the module.config.php.
     * The display - parameter determines which display is active
     */
    const PARAM_DISPLAY = 'display';

    const ROUTE_DEFAULT = 'campustv/anzeige-manager/default';

    const FLASHMESSENGER_CREATE_SUCCESS   = 'Erstellen erfolgreich!';
    const FLASHMESSENGER_EDIT_SUCCESS     = 'Bearbeiten erfolgreich!';
    const FLASHMESSENGER_DELETE_SUCCESS   = 'Löschen erfolgreich!';
    const FLASHMESSENGER_DELETE_CANCELED  = 'Löschen abgebrochen!';



    public function indexAction() {
        $content = __METHOD__ . "<br/>";

        return array('content' => $content);
    }




    public function showAnzeigeAction() {

        $display = $this->params('display');

        $active   = $this->getService('Anzeige')->fetchAllActive($display);
        $outdated = $this->getService('Anzeige')->fetchAllOutdated($display);
        $future   = $this->getService('Anzeige')->fetchAllFuture($display);

        $viewModel = new ViewModel(
                array(
                      'active'               => $active,
                      'outdated'             => $outdated,
                      'future'               => $future,
                      'flashMessagesSuccess' => $this->flashMessenger()->getSuccessMessages(),
                      'flashMessagesInfo'    => $this->flashMessenger()->getInfoMessages(),
                      'flashMessagesFail'    => $this->flashMessenger()->getErrorMessages(),
                      'route'                => self::ROUTE_DEFAULT,
                     )
        );

        return $viewModel;
    }


    public function createAnzeigeAction(){

        $form = $this->getService('Anzeige')->getForm();

//        var_dump($request->getPost());

        if(!$this->getRequest()->isPost()){
            return array('form' => $form, 'route' => self::ROUTE_DEFAULT);
        }

        $anzeigeModel = $this->getService('Anzeige')->createModel();

//            $form->setInputFilter($anzeigeModel->getInputFilter());
        $form->setData($this->getRequest()->getPost());


        if($form->isValid()){

            $anzeigeModel->exchangeArray($form->getData());
            $anzeigeModel->setWahrscheinlichkeit(5)
                         ->setImwarenkorb(0);


            var_dump($this->getRequest()->getPost()[Entity\Anzeige::TBL_COL_DISPLAY_ID]);

            $this->getService('Anzeige')->saveForAllDisplays($anzeigeModel, $this->getRequest()->getPost()[Entity\Anzeige::TBL_COL_DISPLAY_ID]);


            $this->flashMessenger()->addSuccessMessage(self::FLASHMESSENGER_CREATE_SUCCESS);

            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show-anzeige'));
        }



        return array('form' => $form, 'route' => self::ROUTE_DEFAULT);
    }

    /**
     * editAnzeigeAction allows to edit an existing "Anzeige"
     * @fixme Something is wrong with that. Editing doesn't work yet! $form->isValid() returns false
     * @return \Zend\View\Model\ViewModel
     */
    public function editAnzeigeAction(){

        $id = (int) $this->params()->fromRoute('id',0);

        if (!$id) {
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array(
                'action' => 'create-anzeige'
            ));
        }

        $anzeigeModel = $this->getService('Anzeige')->get($id);
        $urlModel     = $this->getService('Url')    ->getUrlModel($anzeigeModel->getSuchId(), $anzeigeModel->getUrl());


        $form         = $this->getService('Anzeige')->getForm($anzeigeModel);



        if(!$this->getRequest()->isPost()){
            return array('form' => $form, 'id' => $id, 'route' => self::ROUTE_DEFAULT, );
        }

//        $form->setInputFilter($anzeigeModel->getInputFilter());
        $form->setData($this->getRequest()->getPost());


        if(!$form->isValid()){
            return array('form' => $form, 'id' => $id, 'route' => self::ROUTE_DEFAULT, );
        }


        $urlModel->setUrl($form->get('url')->getValue())
                 ->setId($this->getService('Url')->save($urlModel));

        $anzeigeModel->exchangeArray($form->getData()->getArrayCopy());
        $anzeigeModel->setSuchId($urlModel->getId());

        $this->getService('Anzeige')->save($anzeigeModel);

        $this->flashMessenger()->addSuccessMessage(self::FLASHMESSENGER_EDIT_SUCCESS);

        return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show-anzeige'));



    }


    public function deleteAnzeigeAction(){

        $id = (int) $this->params()->fromRoute('id',0);

        if (!$id) {
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array(
                'action' => 'show-anzeige'
            ));
        }

        $form = new DeleteForm();
        $anzeige = $this->getService('Anzeige')->get($id);


        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'nein');

            if ($del == 'ja') {
                $id = (int) $request->getPost('id');

                $this->getService('Url')->delete($anzeige->getSuchId());
                $this->getService('Anzeige')->delete($id);

                $this->flashMessenger()->addSuccessMessage(self::FLASHMESSENGER_DELETE_SUCCESS);

            }
            else{
                $this->flashMessenger()->addInfoMessage(self::FLASHMESSENGER_DELETE_CANCELED);
            }

            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show-anzeige'));


        }

        return array('form' => $form, 'id' => $id, 'anzeige' => $anzeige, 'route' => self::ROUTE_DEFAULT, );

    }


    public function anzeigeFileAction(){


        $form = new \Campustv\Form\AnzeigeFileForm();

        $anzeigeFile = new \Campustv\Model\File\AnzeigeFile();

        $anzeigeFileModel = new \Campustv\Model\Entity\AnzeigeFile();
        $anzeigeFileModel ->setEnterpriseName('ALTEN Engineering')
                          ->setEnterpriseLogo('<img src="/getBLOB.php?PARID=2114" width="200px"/>')
                          ->setJobTitle("Ingenieur (m/w) Fahrzeugelektronik")
                          ->setEnterpriseContact(array('street' => 'Karchestraße 3-7', 'zip' => '96450', 'town' => 'Coburg'))
                          ->setRequirements(array('Studium','Mechatronik','Fahrzeugtechnik','Elektrotechnik'))
                          ->setDescription(array('Spannende Ingenieurkarriere', 'Projektvielfalt'));

//        $anzeigeFileModel ->setEnterpriseName('<input name="Jobtitel" type="text" value="Unternehmen">')
//                          ->setEnterpriseLogo('<input name="Jobtitel" type="text" value="Unternehmenslogo">')
//                          ->setJobTitle('<input name="Jobtitel" type="text" value="Jobtitel">')
//                          ->setEnterpriseContact(array('street' => '<input name="Jobtitel" type="text" value="Straße">', 'zip' => '<input name="Jobtitel" type="text" value="PLZ">', 'town' => '<input name="Jobtitel" type="text" value="Ort">'))
//                          ->setRequirements(array('<input name="Jobtitel" type="text" value="Feld1">', '<input name="Jobtitel" type="text" value="Feld2">', '<input name="Jobtitel" type="text" value="Feld3">', '<input name="Jobtitel" type="text" value="Feld4">'))
//                          ->setDescription(array('<input name="Jobtitel" type="text" value="Feld1">', '<input name="Jobtitel" type="text" value="Feld2">', '<input name="Jobtitel" type="text" value="Feld3">', '<input name="Jobtitel" type="text" value="Feld4">'));

        $viewModel = new ViewModel(array('content' => $anzeigeFileModel));
        $viewModel->setTemplate('/campustv/manager/anzeige-template.phtml');
        $viewModel->setTerminal(true);

        $html = $this->getServiceLocator()->get('viewrenderer')->render($viewModel);



        $anzeigeFile->save('ALTEN Engineering','test.html', $html);
        $file = $anzeigeFile->read('ALTEN Engineering', 'test.html');



        return \Futhuer\Layout::disableLayout(new ViewModel(array('content' => $file)));

    }


    private function _createHTMLAnzeige($anzeigeFileModel){

        $doctype  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

        $htmlOpen = '<html xmlns="http://www.w3.org/1999/xhtml">';

        $head     = '<head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Campus-TV</title>
                        <link href="/anzeigen.css" rel="stylesheet" type="text/css">
                        <script src="/datum.js" type="text/javascript"></script>
                     </head>';

        $headline =  '<div id="headline">
                        CampusTV - Stellenmarkt
                     </div>';

        $date     = '<div id="datum" align="left">
                        <script type="text/javascript">
                            document.write(getAktuellesDatum());
                        </script>
                    </div>';

        $adress   = '<div class="adresse">' .
                                    $anzeigeFileModel->getEnterpriseName() . '<br/>' .
                                    $anzeigeFileModel->getEnterpriseContact()['street'] . ' <br/>' .
                                    $anzeigeFileModel->getEnterpriseContact()['zip'] . ' ' .
                                    $anzeigeFileModel->getEnterpriseContact()['town'] .
                   '</div>';

        $requirements = function($anzeigeModel){

            $result = '';

            foreach($anzeigeModel->getRequirements() as $requirement){
                $result .= '<li>' . $requirement . '</li>';
            }

            return $result;

        };

        $descriptions = function($anzeigeModel){

            $result = '';

            foreach($anzeigeModel->getDescription() as $description){
                $result .= '<li>' . $description . '</li>';
            }

            return $result;

        };

        return
                $doctype  .
                $htmlOpen .
                $head     .

                 '  <body style="background:#FFF">
                        <div class="bg">
                            <div class="header">' .

                $headline .

                 '              <div id="futlogo"></div> '
                                . $date . '


                                <div id="ausgabe" align="right">
                                    <br/>
                                </div>
                            </div>

                            <div class="body">

                                <div class="stelle"> ' .
                                    $anzeigeFileModel->getJobTitle() . '
                                </div>

                                <div class="logo">' .
                                    $anzeigeFileModel->getEnterpriseLogo() .
                                '</div>' .

                                $adress .

                                '<div class="profil">' .
                                    $anzeigeFileModel->getRequirementsHeader() .
                                '</div>'.

                                '<div class="bieten">' .
                                    $anzeigeFileModel->getDescriptionHeader() .
                                '</div>' .


                                '<div style="clear:both" />'.

                                    '<div class="profil2">' .
                                        '<ul>' .
                                            $requirements($anzeigeFileModel) .
                                        '</ul>' .
                                    '</div>' .

                                    '<div class="bieten2">' .
                                        '<ul>' .
                                            $descriptions($anzeigeFileModel) .
                                       ' </ul>' .
                                    '</div>' .

                            '</div>
                    </body>
                </html>
        ';

    }


    /**
     * Returns model service
     * @param string $name Servicename with upper-case first letter
     * @return object
     * @throws Exception\ServiceNotFoundException
     */
    public function getService($name){

        return $this->getServiceLocator()->get('Campustv\Service\\' . $name);
    }


}
