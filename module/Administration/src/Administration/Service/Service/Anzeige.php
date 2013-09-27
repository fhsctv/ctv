<?php

namespace Administration\Service\Service;

use Administration\Model                    as Model;
use Administration\Model\Entity             as Entity;

use Administration\Form\Form\AnzeigeForm    as AnzeigeForm;

use Administration\Service\IService;

class Anzeige extends AbstractService implements IService {


    private $kunden;
    private $positions;
    private $urlTable;


    public function getUrlTable() {
        return $this->urlTable;
    }

    public function setUrlTable(Model\ITable $urlTable) {
        $this->urlTable = $urlTable;
        return $this;
    }


    public function createModel(){
        return new Entity\Anzeige();
    }


    public function get($id){
        return $this->getTable()->get( (int) $id );
    }


    public function getForm(Model\IEntity $anzeigeModel = null){


        $editForm = function($model, $customers, $displays) {
            $selectedCustomer = array($model->getKundenId());
            $selectedDisplay  = array($model->getPositionsId());

            $form = new AnzeigeForm($customers, $selectedCustomer, $displays, $selectedDisplay);
            $form->bind($model);
            $form->get('submit')->setValue('Änderungen speichern');

            $form->setHydrator($this->getHydrator());

            return $form;

        };


        $newForm  = function($customers, $displays){
            $form = new AnzeigeForm($customers, null, $displays, null);
            $form->get('submit')->setValue('Anzeige speichern');

            $form->setHydrator($this->getHydrator());

            return $form;

        };


        if($anzeigeModel){

            return $editForm($anzeigeModel, $this->kunden, $this->positions);
        }

        return $newForm($this->kunden, $this->positions);

    }


    public function fetchAll(){
        return $this->getTable()->fetchAll()->toArray();
    }


    public function fetchAllActive($display = null){
        return $this->getTable()->fetchAllActive($display);
    }


    public function fetchAllOutdated($display = null){
        return $this->getTable()->fetchAllOutdated($display);
    }


    public function fetchAllFuture($display = null){
        return $this->getTable()->fetchAllFuture($display);
    }


    public function save($anzeige){

        assert(is_array($anzeige) || is_a($anzeige, 'Administration\Model\IEntity'));

        $urlEntity = (new Entity\Url())->setUrl($anzeige->getUrl());

        $id = $this->getUrlTable()->save($urlEntity);

        $anzeige->setSuchId($id);

        return $this->getTable()->save($anzeige);
    }


    /**
     * This method updates more "AnzeigeModel" with the date of one, depending
     * one the count of id's in the array $ids.
     * This makes it possible to update an "Anzeige" for more than one display
     * at once.
     * @param \Administration\Model\Anzeige $anzeige
     * @param array $displayIds
     */
    public function saveForAllDisplays(Model\IEntity $anzeige, array $displayIds){

        foreach ($displayIds as $displayId) {

            $this->save($anzeige->setPositionsId((int) $displayId));
        }
    }


    public function delete($id){

        assert(!is_null($id) && is_numeric($id));

        return $this->getTable()->delete( (int) $id );
    }


    public function setPositions(array $positions){
        $this->positions = $positions;
    }
    public function setCustomers(array $customers){
        $this->kunden = $customers;
    }

}

?>
