<?php

namespace Administration\Model;

use Administration\Model\IEntity;


/**
 * @author Juri Zirnsak <jurizirnsak@gmail.com>
 */
interface ITable {

    /**
     * Gets all rows from a database table.
     * @return array | Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchAll();

    /**
     * Gets a row using the primary key
     * @param int $id the primary key
     * @return array | Zend\Db\ResultSet\ResultSetInterface
     * @throws \Exception
     */
    public function get($id);

    /**
     * Inserts or updates a model object into database.
     * @param IEntity $entity
     * @throws \Exception
     * @todo the return of the id is not implemented yet in ZF2, watch for updates
     * @return void | int Returns either id of the new row or nothing on update
     */
    public function save(IEntity $model);

    /**
     * Deletes a row from database using the primary key
     * @param int $id the primary key
     */
    public function delete($id);
}

?>
