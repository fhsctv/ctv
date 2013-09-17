<?php

namespace Campustv\Form\Factory;

use Campustv\Form\Form\InfoscriptForm as InfoscriptForm;
use Campustv\Model;


class Infoscript implements \Zend\ServiceManager\FactoryInterface {

    const SUBMIT_VALUE_SAVE = 'Infoscript speichern';
    const SUBMIT_VALUE_EDIT = 'Änderungen speichern';


    private $entity = null;
    private $form = null;


    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $this->form = new InfoscriptForm();
        $this->form->setHydrator($sm->get('hydrator'));
        $this->form->setInputFilter($sm->get('Campustv\InputFilter\Infoscript')->getInputFilter());

        return $this;
    }

    public function getForm(Model\IEntity $entity = null){

        $this->setEntity($entity);
        $this->wantsEditForm() ? $this->makeEditForm() : $this->makeNewForm();

        return $this->form;

    }

    private function makeEditForm(){
        $this->form->bind($this->entity);
        $this->form->get('submit')->setValue(self::SUBMIT_VALUE_EDIT);
    }

    private function makeNewForm(){
        $this->form->get('submit')->setValue(self::SUBMIT_VALUE_SAVE);
    }

    private function wantsEditForm(){

        return isset($this->entity) || !is_null($this->entity);
    }

}

?>
