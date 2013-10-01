<?php

namespace Administration\Form\Factory;

use Administration\Form\Form\AnzeigeForm as AnzeigeForm;
use Administration\Model;


class Anzeige implements \Zend\ServiceManager\FactoryInterface {

    const SUBMIT_VALUE_SAVE = 'Anzeige speichern';
    const SUBMIT_VALUE_EDIT = 'Änderungen speichern';


    private $entity = null;
    private $form = null;


    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $this->form = new AnzeigeForm();
        $this->form->setHydrator($sm->get('hydrator_anzeige'));
        //$this->form->setInputFilter($sm->get('Administration\InputFilter\Anzeige')->getInputFilter());

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
