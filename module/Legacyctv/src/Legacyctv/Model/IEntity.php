<?php

namespace Legacyctv\Model;

/**
 * @todo Consider configuring hydrator in the module's configuration and remove the dependency to the ArraySerializableInterface. For that you need to implement getter an setter methods in the model classes
 */
interface IEntity extends \Zend\Stdlib\ArraySerializableInterface {

    /**
     *
     * @param array $array
     * @return IEntity FluentInterface
     */
    public function exchangeArray(array $data);

    /**
     * @return array
     */
    public function getArrayCopy();

    /**
     *
     * @return array
     */
    public function toArray();

    public function toDbArray();

    /**
     *
     * @return int Id
     */
    public function getId();

    public function getIdKey();
}

?>
