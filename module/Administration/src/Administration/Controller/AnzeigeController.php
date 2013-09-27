<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Administration\Form\Form\DeleteForm;

use Administration\Model\Entity;

class AnzeigeController extends AbstractActionController {

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

    const ROUTE_DEFAULT = 'administration/anzeige/default';

    const FLASHMESSENGER_CREATE_SUCCESS   = 'Erstellen erfolgreich!';
    const FLASHMESSENGER_EDIT_SUCCESS     = 'Bearbeiten erfolgreich!';
    const FLASHMESSENGER_DELETE_SUCCESS   = 'Löschen erfolgreich!';
    const FLASHMESSENGER_DELETE_CANCELED  = 'Löschen abgebrochen!';



    public function indexAction() {
        $content = __METHOD__ . "<br/>";

        return array('content' => $content);
    }




    public function showAction() {

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


    public function createAction(){

        $form = $this->getService('Anzeige')->getForm();

        if(!$this->hasFormData()){
            return $this->formView($form, 'create');
        }

        if(!$form->setData($this->getFormData())->isValid()){
            return $this->formView($form, 'create');
        }

        $hydrator = $this->getServiceLocator()->get('hydrator_anzeige');

        $anzeigeModel = $hydrator->hydrate($this->getFormData()->toArray(), $this->getService('Anzeige')->createModel());



        $this->getService('Anzeige')->saveForAllDisplays($anzeigeModel, $this->getFormData(Entity\Anzeige::TBL_COL_DISPLAY_ID));



        return $this->success(self::FLASHMESSENGER_CREATE_SUCCESS);
    }

    /**
     * editAnzeigeAction allows to edit an existing "Anzeige"
     * @fixme Something is wrong with that. Editing doesn't work yet! $form->isValid() returns false
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction(){

        $id = $this->getIdParam();

        if (!$id) {
            return $this->redirectToAction('create');
        }

        $anzeigeModel = $this->getService('Anzeige')->get($id);
        $urlModel     = $this->getService('Url')    ->getUrlModel($anzeigeModel->getSuchId(), $anzeigeModel->getUrl());


        $form         = $this->getService('Anzeige')->getForm($anzeigeModel);



        if(!$this->hasFormData()){
            return $this->formView($form, 'edit', $id);
        }

//        $form->setInputFilter($anzeigeModel->getInputFilter());


        if(!$form->setData($this->getFormData())->isValid()){
            return $this->formView($form, 'edit', $id);
        }


        $urlModel->setUrl($form->get('url')->getValue())
                 ->setId($this->getService('Url')->save($urlModel));

//        $anzeigeModel->exchangeArray($form->getData()->getArrayCopy());

        $result = $form->getData();


        $result->setSuchId($urlModel->getId());

        $this->getService('Anzeige')->save($result);

        return $this->success(self::FLASHMESSENGER_EDIT_SUCCESS);



    }


    public function deleteAction(){

        $id = $this->getIdParam();

        if (!$id) {
            return $this->redirectToAction('show');
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

            $this->redirectToAction('show');


        }

        return array('form' => $form, 'id' => $id, 'anzeige' => $anzeige, 'route' => self::ROUTE_DEFAULT, );

    }


    /**
     * Returns model service
     * @param string $name Servicename with upper-case first letter
     * @return object
     * @throws Exception\ServiceNotFoundException
     */
    public function getService($name){

        return $this->getServiceLocator()->get('Administration\Service\\' . lcfirst($name));
    }


    private function hasFormData() {
        return $this->getRequest()->isPost();
    }

    private function getFormData($key = null) {
        return $this->getRequest()->getPost($key);
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
