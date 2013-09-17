<?php

namespace Administration\Model\Table;



use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

use Administration\Model\Entity as Entity;


class Position extends AbstractTable {

    /**
     *
     * @param \Zend\Db\TableGateway\TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }


    public function fetchAll() {
        return parent::fetchAll()->toArray();
    }

    public function getIdKey() {
        return Entity\Position::TBL_COL_ID;
    }

    protected function getColumns(Select $select) {
        return $select;
    }

    protected function getJoin(Select $select) {
        return $select;
    }
}

?>
