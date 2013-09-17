<?php

namespace Campustv\Service\Cache;

use Campustv\Model\IEntity;

class Kunde extends AbstractServiceCache {




    //--------------------------------------------------------------------------
    // Services for KundeModel
    //--------------------------------------------------------------------------


    public function createModel(){
        return $this->getService()->createModel();
    }



    //--------------------------------------------------------------------------
    // Implementation of the ServiceInterface using Cache
    //--------------------------------------------------------------------------


    public function fetchAll() {

        $cacheKey = 'kunde' . '_all';

        if($this->getCache()->hasItem($cacheKey)){
            return $this->getCache()->getItem($cacheKey);
        }

        $resultArray = $this->getService()->fetchAll();
        $this->getCache()->setItem($cacheKey, $resultArray);

        return $resultArray;
    }


    public function get($id) {

        /**
         * This filters the resultArray with all kunden to a resultArray
         * with just one kunde.
         */
        $filter = function($kunde) use ($id){
            return $kunde['PAR_ID'] == $id;
        };

        /**
         * This flattens the result.
         * It makes from
         * array( 0 => array('a'=>1, 'b'=>2, [...] ) )
         * just this:  array('a'=>1, 'b'=>2, [...] )
         */
        $flatten = function($array){
            return call_user_func_array('array_merge', $array);
        };

        $result = $flatten(array_filter($this->fetchAll(), $filter));

        return $this->createModel()->exchangeArray($result);

    }


    public function save(IEntity $kundeModel){

        $this->getCache()->clearByPrefix('kunde');
        return $this->getService()->save($kundeModel);
    }


    public function delete($id){
        if(!$id)
            throw new \Exception('No id given');

        $this->getCache()->clearByPrefix('kunde');
        return $this->getService()->delete( (int) $id );
    }

}

?>