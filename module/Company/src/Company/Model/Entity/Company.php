<?php


namespace Company\Model\Entity;

use Futhuer;

class Company {

    private $name;

    private $contact;


    public function __construct($name, $street, $streetNumber, $zipCode, $town) {
        $this->name = $name;
        $this->contact = new Futhuer\Contact($street, $streetNumber, $zipCode, $town);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }



}

?>
