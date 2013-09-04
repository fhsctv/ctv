<?php

namespace Legacyctv\Model\Table;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

use Legacyctv\Model\Entity;

class AktAnzeige extends AbstractTable {

    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }

    public function deleteByDisplay($display_id) {
        return $this->tableGateway->delete(array(Entity\AktAnzeige::TBL_COL_POSITIONS_ID => $display_id));
    }








    protected function getColumns(Select $select) {
        return $select;
    }

    protected function getIdKey() {
        return Entity\AktAnzeige::TBL_COL_ID;
    }

    protected function getJoin(Select $select) {
        return $select;
    }
}

?>
