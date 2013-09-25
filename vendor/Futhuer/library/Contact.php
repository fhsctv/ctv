<?php

namespace Futhuer;

class Street{
    private $_street;
    private $_streetNumber;

    public function __construct($street, $streetNumber) {
        $this->_street       = $street;
        $this->_streetNumber = $streetNumber;
    }

    public function getStreet() {
        return $this->_street;
    }

    public function setStreet($street) {
        $this->_street = $street;
        return $this;
    }

    public function getStreetNumber() {
        return $this->_streetNumber;
    }

    public function setStreetNumber($streetNumber) {
        $this->_streetNumber = $streetNumber;
        return $this;
    }

    public function __toString() {
        return $this->getStreet() . " " . $this->getStreetNumber();
    }



};

class ZipCode{
    private $_zipCode;

    public function __construct($zipCode) {
        $this->_zipCode = $zipCode;
    }

    public function __toString() {
        return $this->_zipCode;
    }
}

class Contact {

    private $_street;
    private $_zipCode;
    private $_town;
    private $_phone;
    private $_fax;
    private $_email;

    public function __construct($street, $streetNumber, $zipCode, $town) {
        $this->_street  = new Street($street, $streetNumber);
        $this->_zipCode = new ZipCode($zipCode);
        $this->_town    = $town;
    }

    public function getStreet() {
        return $this->_street;
    }

    public function setStreet($street) {
        $this->_street = $street;
        return $this;
    }

    public function getZipCode() {
        return $this->_zipCode;
    }

    public function setZipCode($zipCode) {
        $this->_zipCode = $zipCode;
        return $this;
    }

    public function getTown() {
        return $this->_town;
    }

    public function setTown($town) {
        $this->_town = $town;
        return $this;
    }

    public function getPhone() {
        return $this->_phone;
    }

    public function setPhone($phone) {
        $this->_phone = $phone;
        return $this;
    }

    public function getFax() {
        return $this->_fax;
    }

    public function setFax($fax) {
        $this->_fax = $fax;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($email) {
        $this->_email = $email;
        return $this;
    }





}

?>
