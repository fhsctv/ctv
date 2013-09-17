<?php

namespace Administration\Model\Table;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

use Administration\Model        as Model;
use Administration\Model\Entity as Entity;

class Kunde extends AbstractTable {

    /**
     *
     * @param \Zend\Db\TableGateway\TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }


    public function delete($id) {
        throw new \Exception('\'KUNDE\' IS READ ONLY');
    }


    public function save(Model\IEntity $model) {
        throw new \Exception('\'KUNDE\' IS READ ONLY');
    }


    public function getIdKey() {
        return Entity\Kunde::TBL_COL_ID;
    }


    protected function getColumns(Select $select) {

        $select->columns(array(Entity\Kunde::TBL_COL_ID, Entity\Kunde::TBL_COL_CUSTOMER));
        return $select->order(Entity\Kunde::TBL_COL_CUSTOMER);
    }

    
    protected function getJoin(Select $select) {
        return $select;
    }
}

?>
