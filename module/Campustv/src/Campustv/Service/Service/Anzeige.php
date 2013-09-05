<?php

namespace Campustv\Service\Service;

use Campustv\Model                    as Model;
use Campustv\Model\Entity             as Entity;

use Campustv\Form\Form\AnzeigeForm    as AnzeigeForm;

use Campustv\Service\IService;

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

            return $form;

        };


        $newForm  = function($customers, $displays){
            $form = new AnzeigeForm($customers, null, $displays, null);
            $form->get('submit')->setValue('Anzeige speichern');

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


    public function fetchAllActive($display){
        return $this->getTable()->fetchAllActive($display)->toArray();
    }


    public function fetchAllOutdated($display){
        return $this->getTable()->fetchAllOutdated($display)->toArray();
    }


    public function fetchAllFuture($display){
        return $this->getTable()->fetchAllFuture($display)->toArray();
    }


    public function save(Model\IEntity $anzeigeModel){

        $urlEntity = new Entity\Url();
        $urlEntity->setUrl($anzeigeModel->getUrl());
        $id = $this->getUrlTable()->save($urlEntity);

        $anzeigeModel->setSuchId($id);


        return $this->getTable()->save($anzeigeModel);
    }


    /**
     * This method updates more "AnzeigeModel" with the date of one, depending
     * one the count of id's in the array $ids.
     * This makes it possible to update an "Anzeige" for more than one display
     * at once.
     * @param \Campustv\Model\Anzeige $anzeige
     * @param array $displayIds
     */
    public function saveForAllDisplays(Model\IEntity $anzeige, array $displayIds){

        foreach ($displayIds as $displayId) {

            $this->save($anzeige->setPositionsId($displayId));
        }
    }


    public function delete($id){
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
