<?php

namespace Campustv\Service\Cache;

/**
 * @link http://framework.zend.com/manual/2.0/en/user-guide/forms-and-actions.html
 */
use Zend\InputFilter\InputFilterAwareInterface;

use Campustv\Model\IEntity;

class Anzeige extends AbstractServiceCache implements InputFilterAwareInterface {




    //--------------------------------------------------------------------------
    // Services for AnzeigeModel
    //--------------------------------------------------------------------------


    public function createModel(){
        return $this->getService()->createModel();
    }



    //--------------------------------------------------------------------------
    // Services for Form
    //--------------------------------------------------------------------------


    public function getForm(IEntity $anzeigeModel = null){

        return $this->getService()->getForm($anzeigeModel);
    }



    // Services for formfiltering: implementing InputFilterAwareInterface


    public function getInputFilter() {
        return $this->getService()->getInputFilter();
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
        return $this->getService()->setInputFilter($inputFilter);
    }




    //--------------------------------------------------------------------------
    // Fetch methods which depend on time
    //--------------------------------------------------------------------------


    public function fetchAllActive($display) {


        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future anzeiges.
         */
        $filter = function($anzeige) use ($display) {

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($anzeige['SCHALTUNGSANFANG']) <= strtotime($today))
                    &&
                   (strtotime($anzeige['SCHALTUNGSENDE']) >= strtotime($today))
                   && (($anzeige['POSITIONS_ID'] == $display) || ($display == NULL));

        };


        return array_filter($this->fetchAll(), $filter);

    }


    public function fetchAllOutdated($display) {

        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future anzeiges.
         */
        $filter = function($anzeige) use ($display) {

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($anzeige['SCHALTUNGSENDE']) < strtotime($today))
                   && (($anzeige['POSITIONS_ID'] == $display) || ($display == NULL));

        };

        return array_filter($this->fetchAll(), $filter);

    }


    public function fetchAllFuture($display) {

        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future anzeiges.
         */
        $filter = function($anzeige) use ($display) {

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($anzeige['SCHALTUNGSANFANG']) > strtotime($today))
                   && (($anzeige['POSITIONS_ID'] == $display) || ($display == NULL));
        };

        return array_filter($this->fetchAll(), $filter);

    }


    public function saveForAllDisplays(IEntity $anzeige, array $displayIds){
        $this->getCache()->clearByPrefix('anzeige');
        return $this->getService()->saveForAllDisplays($anzeige, $displayIds);
    }


    //--------------------------------------------------------------------------
    // Implementation of the ServiceInterface using Cache
    //--------------------------------------------------------------------------


    public function fetchAll() {

        $cacheKey = 'anzeige' . '_all';

        if($this->getCache()->hasItem($cacheKey)){
            return $this->getCache()->getItem($cacheKey);
        }

        $resultArray = $this->getService()->fetchAll();
        $this->getCache()->setItem($cacheKey, $resultArray);

        return $resultArray;
    }


    public function get($id) {

        /**
         * This filters the resultArray with all anzeiges to a resultArray
         * with just one anzeige.
         */
        $filter = function($anzeige) use ($id){
            return $anzeige['ID'] == $id;
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


    public function save(IEntity $anzeigeModel){

        $this->getCache()->clearByPrefix('anzeige');
        return $this->getService()->save($anzeigeModel);
    }


    public function delete($id){
        if(!$id)
            throw new \Exception('No id given');

        $this->getCache()->clearByPrefix('anzeige');
        return $this->getService()->delete( (int) $id );
    }

}

?>