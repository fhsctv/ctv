<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Administration\Form\Form\DeleteForm;

class InfoscriptController extends AbstractActionController {

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

    const ROUTE_DEFAULT = 'administration/infoscript/default';

    const FLASHMESSENGER_CREATE_SUCCESS   = 'Erstellen erfolgreich!';
    const FLASHMESSENGER_EDIT_SUCCESS     = 'Bearbeiten erfolgreich!';
    const FLASHMESSENGER_DELETE_SUCCESS   = 'Löschen erfolgreich!';
    const FLASHMESSENGER_DELETE_CANCELED  = 'Löschen abgebrochen!';



    public function indexAction() {
        $content = __METHOD__ . "<br/>";

        return array('content' => $content);
    }



    public function showInfoscriptAction() {
        $content = __METHOD__;


        

        $active   = $this->getService('Infoscript')->fetchAllActive();
        $outdated = $this->getService('Infoscript')->fetchAllOutdated();
        $future   = $this->getService('Infoscript')->fetchAllFuture();

        $viewModel = new ViewModel(
                array('content'      => $content,
                      'active'       => $active,
                      'outdated'     => $outdated,
                      'future'       => $future,
                      'flashMessagesSuccess' => $this->flashMessenger()->getSuccessMessages(),
                      'flashMessagesInfo'    => $this->flashMessenger()->getInfoMessages(),
                      'flashMessagesFail'    => $this->flashMessenger()->getErrorMessages(),
                      'route' => self::ROUTE_DEFAULT,
                     )
        );

        return $viewModel;
    }

    public function detailInfoscriptAction(){

        $id = $this->params()->fromRoute('id');

        if(!$id){
            $this->flashMessenger()->addErrorMessage('Dieses Infoscript gibt es nicht');
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show-infoscript'));
        }

        return array('infoscript' => $this->getService('Infoscript')->get($id), 'route' => self::ROUTE_DEFAULT, );



    }

    public function createInfoscriptAction(){

        $form       = $this->getService('Infoscript')->getForm();

        if(!$this->getRequest()->isPost()){
            return array('form' => $form, 'route' => self::ROUTE_DEFAULT,);
        }

        if($this->createInfoscriptUsingFormData($form, self::FLASHMESSENGER_CREATE_SUCCESS)){
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT,
                    array('action' => 'show-infoscript'));
        }

        return array('form' => $form, 'route' => self::ROUTE_DEFAULT,);
    }


    public function editInfoscriptAction(){

        $id = (int) $this->params()->fromRoute(self::PARAM_ID,0);

        if (!$id) {
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array(
                'action' => 'create-infoscript'
            ));
        }

        $infoscript = $this->getService('Infoscript')->get($id);


        $form       = $this->getService('Infoscript')->getForm($infoscript);

        if(!$this->getRequest()->isPost()){
            return array('form' => $form, 'id'=>$id, 'route' => self::ROUTE_DEFAULT,);
        }



        if($this->createInfoscriptUsingFormData($form, self::FLASHMESSENGER_EDIT_SUCCESS)){
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT,
                    array('action' => 'show-infoscript'));
        }


        return array('form' => $form,'id' => $id, 'route' => self::ROUTE_DEFAULT,);
    }


    public function deleteInfoscriptAction(){
        $id = (int) $this->params()->fromRoute('id',0);

        if (!$id) {
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array(
                'action' => 'show-infoscript'
            ));
        }

        $form = new DeleteForm();
        $infoscript = $this->getService('Infoscript')->get($id);


        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del', 'nein');

            if ($del == 'ja') {
                $id = (int) $this->getRequest()->getPost('id');
                $this->getService('Infoscript')->delete($id);
                $this->flashMessenger()->addSuccessMessage(self::FLASHMESSENGER_DELETE_SUCCESS);
            }
            else {
                $this->flashMessenger()->addInfoMessage(self::FLASHMESSENGER_DELETE_CANCELED);
            }

            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show-infoscript'));

        }

        return array('form' => $form, 'id' => $id, 'infoscript' => $infoscript, 'route' => self::ROUTE_DEFAULT,);

    }


    private function createInfoscriptUsingFormData($form, $successMessage){

        $form->setData($this->getRequest()->getPost());

//        var_dump($this->getRequest()->getPost(), $form);

        if($form->isValid()){

            $data = $form->getData(); //$form->getData() returns infoscriptModel on edit of an infoscript, because it used bind() method of form

            if(is_object($data)){
                $this->getService('Infoscript')->save($data);
                return true;
            }

            $infoscript = $this->getService('Infoscript')->createModel();
            //$infoscript->exchangeArray($form->getData()); //$form->getData() returns array on creation of new infoscript
            $this->getServiceLocator()->get('hydrator')->hydrate($form->getData(), $infoscript);

            var_dump($infoscript);

            $this->getService('Infoscript')->save($infoscript);

            $this->flashMessenger()->addSuccessMessage($successMessage);
            return true;
        }
        return false;
    }


    /**
     * Returns model service
     * @param string $name Servicename with upper-case first letter
     * @return object
     * @throws Exception\ServiceNotFoundException
     */
    public function getService($name){

        return $this->getServiceLocator()->get('Administration\Service\\' . $name);
    }


}
