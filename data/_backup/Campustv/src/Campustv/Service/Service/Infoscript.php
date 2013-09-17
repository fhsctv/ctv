<?php

namespace Campustv\Service\Service;

use Campustv\Service\IService;
use Campustv\Model\IEntity                as IEntity;
use Campustv\Model\Entity\Infoscript      as InfoscriptModel;

final class Infoscript extends AbstractService implements IService {


    private $formFactory;

    public function setFormFactory($formFactory){
        $this->formFactory = $formFactory;
        return $this;
    }

    public function getFormFactory(){
        return $this->formFactory;
    }




    //--------------------------------------------------------------------------
    // Services for InfoscriptModel
    //--------------------------------------------------------------------------


    public function createModel(){
        return new InfoscriptModel();
    }



    //--------------------------------------------------------------------------
    // Services for Form
    //--------------------------------------------------------------------------


    public function getForm(IEntity $infoscriptModel = null){

        return $this->getFormFactory()->getForm($infoscriptModel);

    }

    //--------------------------------------------------------------------------
    // Fetch methods which depend on time
    //--------------------------------------------------------------------------


    public function fetchAllActive(){

        return $this->getTable()->fetchAllActive();
    }


    public function fetchAllOutdated(){

        return $this->getTable()->fetchAllOutdated();
    }


    public function fetchAllFuture(){

        return $this->getTable()->fetchAllFuture();
    }




    //--------------------------------------------------------------------------
    // Implementation of the ServiceInterface
    //--------------------------------------------------------------------------


    public function fetchAll(){

        return $this->getTable()->fetchAll();
    }


    public function get($id){
        return $this->getTable()->get( (int) $id );
    }


    public function save(IEntity $infoscriptModel){

        return $this->getTable()->save($infoscriptModel);
    }


    public function delete($id){
        if(!$id)
            throw new \Exception('No id given');

        return $this->getTable()->delete( (int) $id );
    }

}

?>