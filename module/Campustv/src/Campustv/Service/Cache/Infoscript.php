<?php

namespace Campustv\Service\Cache;

/**
 * @link http://framework.zend.com/manual/2.0/en/user-guide/forms-and-actions.html
 */
use Zend\InputFilter\InputFilterAwareInterface;

use Campustv\Model\IEntity;

class Infoscript extends AbstractServiceCache implements InputFilterAwareInterface {




    //--------------------------------------------------------------------------
    // Services for InfoscriptModel
    //--------------------------------------------------------------------------


    public function createModel(){
        return $this->getService()->createModel();
    }



    //--------------------------------------------------------------------------
    // Services for Form
    //--------------------------------------------------------------------------


    public function getForm(IEntity $infoscriptModel = null){

        return $this->getService()->getForm($infoscriptModel);
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


    public function fetchAllActive() {


        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future infoscripts.
         */
        $filter = function($infoscript){

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($infoscript['STARTDATUM']) <= strtotime($today))
                    &&
                   (strtotime($infoscript['ABLAUFDATUM']) >= strtotime($today));

        };


        return array_filter($this->fetchAll(), $filter);

    }


    public function fetchAllOutdated() {

        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future infoscripts.
         */
        $filter = function($infoscript){

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($infoscript['ABLAUFDATUM']) < strtotime($today));

        };

        return array_filter($this->fetchAll(), $filter);

    }


    public function fetchAllFuture() {

        /**
         * This Closure filters the resultArray so that the result does not contain
         * outdated and future infoscripts.
         */
        $filter = function($infoscript){

            $today = date('d.m.Y');

            //the following compares to dates
            //TODO use DateTime Objects to compare
            return (strtotime($infoscript['STARTDATUM']) > strtotime($today));
        };

        return array_filter($this->fetchAll(), $filter);

    }




    //--------------------------------------------------------------------------
    // Implementation of the ServiceInterface using Cache
    //--------------------------------------------------------------------------


    public function fetchAll() {

        $cacheKey = 'infoscript' . '_all';

        if($this->getCache()->hasItem($cacheKey)){
            return $this->getCache()->getItem($cacheKey);
        }

        $resultArray = $this->getService()->fetchAll();
        $this->getCache()->setItem($cacheKey, $resultArray);

        return $resultArray;
    }


    public function get($id) {

        /**
         * This filters the resultArray with all infoscripts to a resultArray
         * with just one infoscript.
         */
        $filter = function($infoscript) use ($id){
            return $infoscript['ID'] == $id;
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


    public function save(IEntity $infoscriptModel){

        $this->getCache()->clearByPrefix('infoscript');
        return $this->getService()->save($infoscriptModel);
    }


    public function delete($id){
        if(!$id)
            throw new \Exception('No id given');

        $this->getCache()->clearByPrefix('infoscript');
        return $this->getService()->delete( (int) $id );
    }

}

?>