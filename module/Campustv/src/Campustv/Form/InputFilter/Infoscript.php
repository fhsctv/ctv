<?php

namespace Campustv\Form\InputFilter;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

use Campustv\Model\Entity\Infoscript as InfoscriptModel;

class Infoscript implements InputFilterAwareInterface {

    private $inputFilter  = null;
    private $inputFactory = null;

    public function getInputFilter() {
        if ($this->inputFilter)
            return $this->inputFilter;


        $this->inputFilter  = new InputFilter();
        $this->inputFactory = new InputFactory();

        $this->inputFilter->add($this->getIdFilter())
                          ->add($this->getStartDateFilter())
                          ->add($this->getEndDateInput())
                          ->add($this->getUrlInput());

        return $this->inputFilter;
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    private function getIdFilter(){

        return $this->inputFactory->createInput(
            array(
                'name' => strtolower(InfoscriptModel::TBL_COL_ID),
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )
        );
    }

    private function getStartDateFilter() {

        return $this->inputFactory->createInput(array(
                'name' => strtolower(InfoscriptModel::TBL_COL_BEGIN_DATE),
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), //remove unwanted html
                    array('name' => 'StringTrim'), //remove unwanted white spaces
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
            )
        );
    }

    private function getEndDateInput() {

        return $this->inputFactory->createInput(
            array(
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
            )
        );
    }

    private function getUrlInput() {

        return $this->inputFactory->createInput(array(
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
            )
        );
    }

}

?>
