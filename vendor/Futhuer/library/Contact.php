<?php

namespace Futhuer;

class Street{
    private $_street;
    private $_streetNumber;

    public function __construct($street, $streetNumber) {
        $this->_street       = $street;
        $this->_streetNumber = $streetNumber;
    }
};

class ZipCode{
    private $_zipCode;

    public function __construct($zipCode) {
        $this->_zipCode = $zipCode;
    }
}

class Contact {

    private $_street;
    private $_zipCode;
    private $_town;

    public function __construct($street, $streetNumber, $zipCode, $town) {
        $this->_street  = new Street($street, $streetNumber);
        $this->_zipCode = new ZipCode($zipCode);
        $this->_town    = $town;
    }



}

?>
