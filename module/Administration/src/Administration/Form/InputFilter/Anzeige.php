<?php

namespace Administration\Form\InputFilter;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

use Administration\Model\Entity\Anzeige as AnzeigeModel;

class Anzeige implements InputFilterAwareInterface {

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


    }

    private function getStartDateFilter() {


    }

    private function getEndDateInput() {


    }

    private function getUrlInput() {

      
    }

}

?>
