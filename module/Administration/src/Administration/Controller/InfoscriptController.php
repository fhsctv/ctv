<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Administration\Form\Form\DeleteForm;

class InfoscriptController extends AbstractActionController {

    /**
     * GET- parameters are defined in the router of the module.config.php.
     * The id - parameter determines which slide has to be shown
     */
    const PARAM_ID = 'id';

    const ROUTE_DEFAULT = 'administration/infoscript/default';

    const FLASHMESSENGER_CREATE_SUCCESS  = 'Erstellen erfolgreich!';
    const FLASHMESSENGER_EDIT_SUCCESS    = 'Bearbeiten erfolgreich!';
    const FLASHMESSENGER_DELETE_SUCCESS  = 'Löschen erfolgreich!';
    const FLASHMESSENGER_DELETE_CANCELED = 'Löschen abgebrochen!';

    public function indexAction()  {
        $content = __METHOD__ . "<br/>";

        return array('content' => $content);
    }

    public function showAction()   {

        $active   = $this->getService('Infoscript')->fetchAllActive();
        $outdated = $this->getService('Infoscript')->fetchAllOutdated();
        $future   = $this->getService('Infoscript')->fetchAllFuture();

        return array(
            'active'               => $active,
            'outdated'             => $outdated,
            'future'               => $future,
            'flashMessagesSuccess' => $this->flashMessenger()->getSuccessMessages(),
            'flashMessagesInfo'    => $this->flashMessenger()->getInfoMessages(),
            'flashMessagesFail'    => $this->flashMessenger()->getErrorMessages(),
            'route'                => self::ROUTE_DEFAULT,
        );
    }

    public function detailAction() {

        $id = $this->getIdParam();

        if (!$id) {
            return $this->error('Dieses Infoscript gibt es nicht');
        }

        return array('infoscript' => $this->getService('Infoscript')->get($id), 'route' => self::ROUTE_DEFAULT,);
    }

    public function createAction() {

        $form = $this->getService()->getForm();

        if (!$this->hasFormData()) {
            return $this->formView($form, 'create');
        }

        if (!$form->setData($this->getFormData())->isValid()) {
            return $this->formView($form, 'create');
        }

        $this->getService()->save($form->getData());

        return $this->success(self::FLASHMESSENGER_CREATE_SUCCESS);

    }

    public function editAction()   {

        $id = $this->getIdParam();

        if (!$id) {
            return $this->redirectToAction('create');
        }

        $infoscript = $this->getService()->get($id);
        $form       = $this->getService()->getForm($infoscript);

        if (!$this->hasFormData()) {
            return $this->formView($form, 'edit', $id);
        }

        if (!$form->setData($this->getFormData())->isValid()) {
            return $this->formView($form, 'edit', $id);
        }

        $this->getService()->save($form->getData());

        return $this->success(self::FLASHMESSENGER_EDIT_SUCCESS);
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array(
                        'action' => 'show'
            ));
        }

        $form = new DeleteForm();
        $infoscript = $this->getService('Infoscript')->get($id);


        if (!$this->getRequest()->isPost()) {
            return array('form' => $form, 'id' => $id, 'infoscript' => $infoscript, 'route' => self::ROUTE_DEFAULT,);
        }

        $del = $this->getRequest()->getPost('del', 'nein');

        if ($del == 'ja') {
            $id = (int) $this->getRequest()->getPost('id');
            $this->getService('Infoscript')->delete($id);
            $this->flashMessenger()->addSuccessMessage(self::FLASHMESSENGER_DELETE_SUCCESS);
        } else {
            $this->flashMessenger()->addInfoMessage(self::FLASHMESSENGER_DELETE_CANCELED);
        }

        return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => 'show'));
    }



    /**
     * Returns model service
     * @param string $name Servicename with upper-case first letter
     * @return object
     * @throws Exception\ServiceNotFoundException
     */
    public function getService()   {
        return $this->getServiceLocator()->get('Administration\Service\Infoscript');
    }


    private function hasFormData() {
        return $this->getRequest()->isPost();
    }

    private function getFormData($key = null, $default = null) {
        return $this->getRequest()->getPost($key, $default);
    }

    private function formView($form, $action, $id = null){
        return is_null($id)
            ? array('form' => $form, 'action' => $action, 'route' => self::ROUTE_DEFAULT)
            : array('form' => $form, 'action' => $action, 'route' => self::ROUTE_DEFAULT, 'id' => $id);
    }

    private function success($message){

        $this->flashMessenger()->addSuccessMessage($message);

        return $this->redirectToAction('show');
    }

    private function error($message){
        $this->flashMessenger()->addErrorMessage($message);
            return $this->redirectToAction('show');
    }

    private function redirectToAction($action) {
        return $this->redirect()->toRoute(self::ROUTE_DEFAULT, array('action' => $action));
    }

    private function getIdParam(){
        return (int) $this->params()->fromRoute(self::PARAM_ID, null);
    }

}
