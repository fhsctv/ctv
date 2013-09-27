<?php

namespace Administration\Service\Service;

use Administration\Service\IService;
use Administration\Model\IEntity                as IEntity;
use Administration\Model\Entity\Infoscript      as InfoscriptModel;

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


    public function save($infoscript){

        assert(is_array($infoscript) || is_a($infoscript, 'Administration\Model\IEntity'));

        if(is_object($infoscript)){
            return $this->getTable()->save($infoscript);
        }

        $infoscriptEntity = $this->getHydrator()->hydrate($infoscript, $this->createModel());
        return $this->getTable()->save($infoscriptEntity);

    }


    public function delete($id){

        assert(!is_null($id) && is_numeric($id));

        return $this->getTable()->delete( (int) $id );
    }

}

?>