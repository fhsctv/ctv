<?php

namespace Campustv\Service\Service;

/**
 * @link http://framework.zend.com/manual/2.0/en/user-guide/forms-and-actions.html
 */
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Campustv\Service\IService;
use Campustv\Model\IEntity                as IEntity;
use Campustv\Model\Entity\Infoscript      as InfoscriptModel;
use Campustv\Form\Form\InfoscriptForm     as InfoscriptForm;

final class Infoscript extends AbstractService implements InputFilterAwareInterface, IService {

    protected $inputFilter;
    protected $hydrator;


    public function getHydrator()
    {
        return $this->hydrator;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
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

        $editForm = function(IEntity $infoscriptModel) {

            $form = new InfoscriptForm();
            $form->setHydrator($this->getHydrator());
            $form->bind($infoscriptModel);

            $form->get('submit')->setValue('Änderungen speichern');
            $form->setInputFilter($this->getInputFilter());

            return $form;
        };

        $newForm  = function() {

            $form = new InfoscriptForm();
            $form->setHydrator($this->getHydrator());
            $form->get('submit')->setValue('Infoscript speichern');
            $form->setInputFilter($this->getInputFilter());

            return $form;
        };


        if($infoscriptModel){
            return $editForm($infoscriptModel);
        }

        return $newForm();

    }



    // Services for formfiltering: implementing InputFilterAwareInterface


    public function getInputFilter() {

        if($this->inputFilter)
            return $this->inputFilter;


        $this->inputFilter = new InputFilter();
        $factory           = new InputFactory();

        // <editor-fold defaultstate="collapsed" desc="Inputs">
        $idInput = $factory->createInput(array(
            'name' => strtolower(InfoscriptModel::TBL_COL_ID),
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        $startDatumInput = $factory->createInput(array(
            'name' => strtolower(InfoscriptModel::TBL_COL_BEGIN_DATE),
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),   //remove unwanted html
                array('name' => 'StringTrim'),  //remove unwanted white spaces
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 10,
                        'max' => 10,
                    ),
                ),
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'd.m.Y',
                    ),
                ),
            ),
        ));

        $ablaufDatumInput = $factory->createInput(array(
            'name' => strtolower(InfoscriptModel::TBL_COL_END_DATE),
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 10,
                        'max' => 10,
                    ),
                ),
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'd.m.Y',
                    ),
                ),
            ),
        ));

        $urlInput = $factory->createInput(array(
            'name' => strtolower(InfoscriptModel::TBL_COL_URL),
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
            ),
        )); // </editor-fold>


        $this->inputFilter->add($idInput);
        $this->inputFilter->add($startDatumInput);
        $this->inputFilter->add($ablaufDatumInput);
        $this->inputFilter->add($urlInput);

        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {

        throw new \Exception("Not used");
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